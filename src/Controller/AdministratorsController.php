<?php
namespace App\Controller;
use App\Entity\Administration;

use App\Form\AdministrationType;
use App\Form\MyaccountType;
use App\Repository\AdministrationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdministratorsController extends AbstractController
{


    /**
     * @Route("/administrators", name="administrators")
     * @param AdministrationRepository $repository
     * @return Response
     */
    public function index(AdministrationRepository $repository)
    {



        $admins=$repository->findAll();


        return $this->render('administrators.html.twig',['admins'=>$admins]);


    }


    /**
     * @route("/bloquer/{id}",name="bloquer")
     * @param Administration $a
     * @param AdministrationRepository $repository
     * @return Response
     */

    public function bloquer(Administration $a,AdministrationRepository $repository)
    {
        $em = $this->getDoctrine()->getManager();

        if($a->getBloquer()==0) {
            $a->setBloquer(1);
            $em->flush();

            return $this->json(['code'=>200,'message'=>'bloqué',200]);

        }
        else
        {
        $a->setBloquer(0);
        $em->flush();
            return $this->json(['code'=>200,'message'=>'admin dbloqué ',200]);
        }




       /* return $this->redirect($_SERVER['HTTP_REFERER']);*/


    }
    /**
     * @route("/delete/{id}",name="deleteadmi")
     * @param Administration $p
     * @return Response
     */

    public function supprimer(Administration  $p)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($p);
        $em->flush();

        $this->addFlash('success', 'The administrator is deleted');


        return $this->redirect($_SERVER['HTTP_REFERER']);


    }

    /**
     * @Route("/addadmin",name="addadmin")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request)
    {

        $admin = new Administration();
        $form = $this->createForm(AdministrationType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $admin->setBloquer(0);
            $admin->setEtat('A');
            $em->persist($admin);
            $em->flush();

            $this->addFlash('success', 'New administrator added');
            return $this->redirect('addadmin');
        }

        return $this->render('addadmin.html.twig', ['admin' => $admin, 'form' => $form->createView()]);

    }
    /**
     * @Route("/edit/{id}",name="edit")
     * @param Administration $res
     * @param Request $request

     * @return Response
     */
    public function modifier(Administration $res, Request $request)
    {

        $form= $this->createForm(MyaccountType::class,$res);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() ) {


                {

                    $em = $this->getDoctrine()->getManager();

                    $em->flush();

                    $this->addFlash('success', ' Information modified:)');


                    return $this->redirect($_SERVER['HTTP_REFERER']);
                }

            }



        return $this->render('editaccount.html.twig',['res' =>$res,'form'=>$form->createView()]) ;
    }


}