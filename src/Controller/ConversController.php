<?php
namespace App\Controller;
use App\Entity\Conversation;
use App\Entity\Administration;
use App\Entity\Utilisateur;
use App\Form\ConversationType;
use App\Form\MessageType;
use App\Form\MesType;
use App\Repository\AdministrationRepository;
use App\Repository\ConversationRepository;
use App\Repository\MessageRepository;
use App\Repository\UtilisateurRepository;
use Exception;
use App\Entity\Message;
use PhpParser\Node\Scalar\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;


class ConversController extends AbstractController
{


    /**
     * @Route("/convers", name="convers")
     * @param ConversationRepository $repository
     * @param MessageRepository $message
     * @return Response
     */
    public function convers(ConversationRepository $repository,MessageRepository $message)
    {
        $convv=$repository->findAll();

        $conv=[];
        $a=new Conversation();
        $a->setId(-1);

        $lastmessage=new Message();
        $lastmessage->setId(-1);

        foreach ($convv as $c)
        {
            $m=$message->mestri($c);
            $conv[]=['conversation'=>$c,'lmes'=>$m[count($m)-1],'mes'=>$m,'trimes'=>$m[count($m)-1]->getDateMess()];



        }
        $columns = array_column( $conv, 'trimes');
        array_multisort($columns, SORT_ASC, $conv);
      $test=false;
        return $this->render('convers.html.twig',['conv'=>$conv,'test'=>$test,'lastmessage'=>$lastmessage,'a'=>$a]);


    }


    /**
     * @Route("/addconvers",name="addconvers")
     * @param Request $request1
     * @param Request $request2
     * @param AdministrationRepository $admin
     * @param ConversationRepository $con
     * @param UtilisateurRepository $uti
     * @return Response
     * @throws Exception
     */
    public function add(Request $request1,Request $request2,AdministrationRepository $admin,ConversationRepository $con,UtilisateurRepository $uti,Security $security)
    {
        $u=$uti->findAll();
        $res=[];
        foreach ($u as $r)
        {
            $conversa=$con->findbyiduti($r);
            if($conversa==null)
            {
                $res[]=$r;
            }


        }








        $convers = new Conversation();
        $message =new Message();

        $form2 = $this->createForm(MessageType::class, $message);
        $form2->handleRequest($request2);

        if ($form2->isSubmitted() && $form2->isValid()) {
            $form = $request2->request->get('select');

            $em = $this->getDoctrine()->getManager();
            $convers->setUtilisateur($uti->findByuser($form));
            $convers->setAdmin($admin->findbyusern($security->getUser()->getUsername()));

            $message->setAdmin($admin->findbyusern($security->getUser()->getUsername()));
            $message->setDateMess(new \DateTime());


            $em->persist($convers);
            $em->flush();
            $message->setConversation($convers);
            $em->persist($message);
            $em->flush();
            return $this->redirect('convers');
        }

        return $this->render('addconv.html.twig', ['res'=>$res,'message' => $message,'form2' => $form2->createView()]);

    }

    /**
     * @route("/getconv/{id}",name="getconv")
     * @param Conversation $a
     * @param ConversationRepository $repository
     * @param MessageRepository $rep2
     * @return Response
     */

    public function getconv(Conversation $a,ConversationRepository $repository,MessageRepository $rep2 )
    {
         $mes=$rep2->mestri($a);
        $test=true;
        $convv=$repository->findAll();

        $conv=[];
        foreach ($convv as $c)
        {
            $m=$rep2->mestri($c);
            $conv[]=['conversation'=>$c,'lmes'=>$m[count($m)-1],'mes'=>$m,'trimes'=>$m[count($m)-1]->getDateMess()];
        }
        $columns = array_column( $conv, 'trimes');
        array_multisort($columns, SORT_DESC, $conv);
        $test=true;
        $lastmessage=$mes[count($mes)-1];
        return $this->render('convers.html.twig',['conv'=>$conv,'test'=>$test,'a'=>$a,'mes'=>$mes,'lastmessage'=>$lastmessage]);



    }

    /**
     * @route("/newmes/{id}",name="newmes")
     * @param Conversation $a
     * @return Response
     * @throws Exception
     */

    public function newmes(Conversation $a)
    {


        $message =new Message();

       $mm= $_POST['mes'];


            $em = $this->getDoctrine()->getManager();
            $message->setAdmin($a->getAdmin());
            $message->setDateMess(new \DateTime());
            $message->setConversation($a);
            $message->setMessage($mm);
            $em->persist($message);
            $em->flush();
             return $this->json(['code'=>200,'message'=>'message ajouter',200]);



    }

    /**
     * @route("/verif/{id}",name="verif")
     * @param Conversation $a
     * @param MessageRepository $rep
     * @return Response
     */
    public function verif(Conversation $a,MessageRepository $rep )
    {

       $m=$rep->mestri($a);
if($m[count($m)-1]->getUtilisateur()==null)
{$k=-1;}
else
{$k=$m[count($m)-1]->getUtilisateur()->getId();}



        return $this->json(['code'=>200,'id'=>$m[count($m)-1]->getId(),'k'=>$k,'message'=>$m[count($m)-1]->getMessage(),200]);

    }
}