<?php
namespace App\Controller;
use App\Entity\Administration;
use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UsersController extends AbstractController
{



    /**
     * @Route("/users", name="users")
     * @param UtilisateurRepository $repository
     * @return Response
     */
    public function index(UtilisateurRepository $repository)
    {



        $users=$repository->findAll();


        return $this->render('users.html.twig',['users'=>$users]);


    }
    /**
     * @route("/bloqueru/{id}",name="bloqueru")
     * @param Utilisateur $a
     * @param UtilisateurRepository $repository
     * @return Response
     */

    public function bloqueru(Utilisateur $a,UtilisateurRepository $repository)
    {
        $em = $this->getDoctrine()->getManager();

        if($a->getBloque()==0) {
            $a->setBloque(1);
            $em->flush();

            return $this->json(['code'=>200,'message'=>'utilsateur bloqué ',200]);

        }
        else
        {
            $a->setBloque(0);
            $em->flush();
            return $this->json(['code'=>200,'message'=>'utilisateur débloqué ',200]);
        }

    }}