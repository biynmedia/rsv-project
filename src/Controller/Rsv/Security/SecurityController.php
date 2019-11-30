<?php

namespace App\Controller\Rsv\Security;

use App\Form\User\UserLoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion.html", name="security_login", methods={"GET|POST"})
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('rsv_home');
         }

        $form = $this->createForm(UserLoginType::class, [
            'email' => $authenticationUtils->getLastUsername()
        ]);

        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('security/login.html.twig', ['form' => $form->createView(), 'error' => $error]);
    }

    /**
     * @Route("/deconnexion.html", name="security_logout", methods={"GET"})
     */
    public function logout()
    {
    }
}
