<?php


namespace App\Controller\Rsv;


use App\Form\Topic\TopicPublicType;
use App\Form\Topic\TopicType;
use App\Topic\PublicTopicRequest;
use App\Topic\PublicTopicRequestHandler;
use App\Topic\TopicRequest;
use App\Topic\TopicRequestHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicController extends AbstractController
{

    /**
     * Create a new Public Topic
     * @Route("/poser-une-question.html", name="public_topic", methods={"GET|POST"})
     * @param Request $request
     * @param PublicTopicRequestHandler $topicRH
     * @return Response
     */
    public function createPublicTopic(Request $request, PublicTopicRequestHandler $topicRH)
    {
        # Create new Topic Request
        $topicReq = new PublicTopicRequest();

        # Create form
        $form = $this->createForm(TopicPublicType::class, $topicReq)
            ->handleRequest($request);

        # Check form submission
        if ($form->isSubmitted() && $form->isValid()) {

            # Handle Topic Workflow
            $topic = $topicRH->handle($topicReq);

            # Add Flash
            $this->addFlash('notice',
                'Merci. Votre question nous ai bien parvenue. Si vous avez renseigné un email, nous vous préviendrons lorsqu un éclairage aura été apporté.');

            # Redirection
            return $this->redirectToRoute('public_topic');
        }

        # Display for to view
        return $this->render('rsv/public/topic.html.twig', [
            'form' => $form->createView()
        ]);
    }

}