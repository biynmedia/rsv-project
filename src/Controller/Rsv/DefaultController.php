<?php


namespace App\Controller\Rsv;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    /**
     * Page d'Accueil
     * @Route("/", name="default_home", methods={"GET"})
     */
    public function home()
    {
        return $this->render('default/home.html.twig');
    }

}