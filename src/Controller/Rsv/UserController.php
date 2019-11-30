<?php


namespace App\Controller\Rsv;


use App\Form\User\UserRegistrationType;
use App\User\UserRequest;
use App\User\UserRequestHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    /**
     * Register new User
     * TODO : Ajouter Google ReCaptcha
     * @Route("inscription.html", name="user_register", methods={"GET|POST"})
     * @param Request $request
     * @param UserRequestHandler $requestHandler
     * @return Response
     */
    public function register(Request $request, UserRequestHandler $requestHandler)
    {

        # Create new user request
        $userRequest = new UserRequest();

        # Create new form based on user request
        $form = $this->createForm(UserRegistrationType::class, $userRequest)
            ->handleRequest($request);

        # Check for submission
        if ($form->isSubmitted() && $form->isValid()) {

            # Register User
            $user = $requestHandler->registerAsUser($userRequest);

            # Flash Message
            $this->addFlash('notice', 'Félicitation, vous pouvez vous connecter !');

            # Redirect
            return $this->redirectToRoute('security_login');

        }

        # Transmit form to view
        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);

    }
}