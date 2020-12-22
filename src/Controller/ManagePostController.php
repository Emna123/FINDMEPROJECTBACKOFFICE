<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Publication;
use App\Repository\CommentaireRepository;
use App\Repository\PublicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManagePostController extends AbstractController
{
    /**
     * @Route("/manage/post", name="manage_post")
     * @param PublicationRepository $repository
     * @return Response
     */
    public function index(PublicationRepository $repository): Response
    {
        $tab=$repository->findAll();

        $post=[];
        foreach ($tab as $a)
        {
            $post[]=['post'=>$a,
                'mult'=>$a->getMutimedia()[0]];
        }

        return $this->render('manage_post/index.html.twig',['post'=>$post]);
    }








/**
 * @route("/resolu/{id}",name="resolu")
 * @param Publication $a
 * @param PublicationRepository $repository
 * @return Response
 */

public function resolu(Publication $a,PublicationRepository $repository)
{
    $em = $this->getDoctrine()->getManager();

    if($a->getStatut()=='N') {
        $a->setStatut('R');
        $em->flush();

        return $this->json(['code'=>200,'message'=>'poste resolut',200]);

    }
    else
    {
        $a->setStatut('N');
        $em->flush();
        return $this->json(['code'=>200,'message'=>'poste nom resolut ',200]);
    }

}

    /**
     * @route("/hide",name="hide")
     * @param PublicationRepository $repository
     * @return Response
     */

    public function hide(PublicationRepository $repository)
    {
        $a=$repository->find($_POST['d']);
        $em = $this->getDoctrine()->getManager();

            $a->setArchiver(1);
            $em->flush();

         $this->addFlash('success', 'POST HIDED');

        return $this->json(['code'=>200,200]);


    }


    /**
     * @route("/details/{id}",name="details")
     * @param Publication $a
     * @param PublicationRepository $repository
     * @return Response
     */

    public function details(Publication $a,PublicationRepository $repository)
    {
        $tab=$a->getCommentaires();
         $mult=$a->getMutimedia();
        return $this->render('manage_post/details.html.twig',['p'=>$a,'tab'=>$tab,'mult'=>$mult,'nbc'=>sizeof($tab)]);


    }

    /**
     * @route("/deletecm",name="deletecm")
     * @param CommentaireRepository $k
     * @return Response
     */

    public function supprimer( CommentaireRepository $k)
    {
        $p=$k->find($_POST['d']);

        $em = $this->getDoctrine()->getManager();
       $p->getUtilisateur()->removeCommentaire($p);
       $em->remove($p);
        $em->flush();
         $test=true;
        return $this->json(['code'=>200,'test'=>$test,200]);



    }

}