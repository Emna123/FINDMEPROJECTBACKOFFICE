<?php
namespace App\Controller;
use App\Entity\Conversation;
use App\Repository\AdministrationRepository;
use App\Repository\ConversationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class WorkController extends AbstractController
{


    /**
     * @Route("/work", name="work")
     * @param ConversationRepository $repository
     * @return Response
     */
    public function work(ConversationRepository $repository)
    {
        $conversation=$repository->findAll();


        return $this->render('work.html.twig',['conversation'=>$conversation]);
    }

    /**
     * @route("/takeconv",name="takeconv")

     * @param Security $security
     * @param ConversationRepository  $k
     * @param AdministrationRepository $admin
     * @return Response
     */

    public function takeme(ConversationRepository  $k,Security $security,AdministrationRepository $admin)
    {
        $p=$k->find($_POST['d']);

        $em = $this->getDoctrine()->getManager();
        $p->setAdmin($admin->findbyusern($security->getUser()->getUsername()));
        foreach ($p->getMessages() as  $a)
        {
            if($a->getUtilisateur()==null)
            { $a->setAdmin($admin->findbyusern($security->getUser()->getUsername()));}
        }
        $em->flush();



        return $this->json(['code'=>200,200]);


    }


    /**
     * @route("/edithand",name="edithand")
     * @param ConversationRepository $k
     * @param Security $security
     * @param AdministrationRepository $admin
     * @return Response
     */

    public function edithand(ConversationRepository  $k,Security $security,AdministrationRepository $admin)
    {
        $p=$k->find($_POST['d']);

        $em = $this->getDoctrine()->getManager();
        $p->setAdmin(null);
        foreach ($p->getMessages() as  $a)
        {
            $a->setAdmin(null);
        }
        $em->flush();



        return $this->json(['code'=>200,200]);


    }
}