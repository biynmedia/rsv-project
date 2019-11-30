<?php


namespace App\Controller\Rsv;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RsvController extends AbstractController
{

    /**
     * Page d'Accueil
     * @Route("/", name="rsv_home", methods={"GET"})
     */
    public function home()
    {
        return $this->render('rsv/home.html.twig');
    }

}