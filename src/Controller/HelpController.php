<?php
namespace App\Controller;
use App\Repository\AdministrationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HelpController extends AbstractController
{


    /**
     * @Route("/help", name="help")
     * @param AdministrationRepository $repository
     * @return Response
     */
    public function help(AdministrationRepository $repository)
    {
$admin=$repository->findAll();
        return $this->render('help.html.twig',['admins'=>$admin]);


    }
}