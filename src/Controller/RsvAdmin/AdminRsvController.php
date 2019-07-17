<?php


namespace App\Controller\RsvAdmin;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminRsvController extends AbstractController
{

    /**
     * @Route("/dashboard", name="admin_dashboard", methods={"GET"})
     */
    public function index()
    {
        return $this->render("admin/dashboard/index.html.twig");
    }
}
