<?php
namespace App\Controller;
use App\Repository\CommentaireRepository;
use App\Repository\MessageRepository;
use App\Repository\PublicationRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{


    /**
     * @Route("/home", name="home")
     */
    public function home(PublicationRepository $repository, MessageRepository $repm ,UtilisateurRepository $rep, CommentaireRepository  $repo): Response
    {
        $em = $this->getDoctrine()->getManager();
        $pubs = $repository->findAll();
        $uti=$rep->findAll();
        $msg=$repm->findAll();
        $res = $repository->findBy(['statut'=>'r']);
        $arch = $repository->findBy(['archiver'=>'0']);
        $comments=$repo->findAll();
        $NbrH = $repository->findBy(['sexe'=>'Homme']);
        $NbrF = $repository->findBy(['sexe'=>'Femme']);
        $commentsTotal = count($comments);
        $totalPubsWithStatusR = count($res);
        $totalPubs = count($pubs);
        $totalut = count($uti);
        $NbrHomme = count($NbrH);
        $messages = count($msg);
        $arch= count($arch);
        $narch=$totalPubs-$arch;

        $NbrFemme = count($NbrF);
        $PostNotResolved =$totalPubs - $totalPubsWithStatusR ;
        return $this->render('home.html.twig',
            ['totalPubsWithStatusR'=>$totalPubsWithStatusR,
                'totalPubs'=>$totalPubs,
                'commentsTotal'=>$commentsTotal,
                'narch'=>$narch,
                'arch'=>$arch,
                'NbrHomme'=>$NbrHomme,
                'NbrFemme'=>$NbrFemme,
                'messages'=>$messages,

                'PostNotResolved'=>$PostNotResolved,
                'totalut'=>$totalut]);




    }
}