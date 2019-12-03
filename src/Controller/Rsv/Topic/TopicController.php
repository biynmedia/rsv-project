<?php


namespace App\Controller\Rsv\Topic;


use App\Form\Topic\TopicType;
use App\Topic\TopicRequest;
use App\Topic\TopicRequestHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/topic")
 */
class TopicController extends AbstractController
{
    /**
     * Create a new Topic
     * @Route("/create", name="topic_create", methods={"GET|POST"})
     * @param Request $request
     * @param TopicRequestHandler $topicRH
     * @return Response
     */
    public function createTopic(Request $request, TopicRequestHandler $topicRH)
    {
        # Create new Topic Request
        $topicReq = new TopicRequest();
        $topicReq->user = $this->getUser();

        # Create form
        $form = $this->createForm(TopicType::class, $topicReq)
            ->handleRequest($request);

        # Check form submission
        if ($form->isSubmitted() && $form->isValid()) {

            # Handle Topic Workflow
            $topic = $topicRH->handle($topicReq);

            # Add Flash
            $this->addFlash('notice',
                'Enregistré. Vous pouvez maintenant apporter un éclairage.');

            # Redirection
            return $this->redirectToRoute('admin_topic', [
               'id' => $topic->getId(),
               'alias' => $topic->getAlias()
            ]);
        }

        # Display for to view
        return $this->render('rsv/topic/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Edit a Topic
     */
    public function editTopic()
    {

    }

    /**
     * Delete a Topic
     */
    public function deleteTopic()
    {

    }
}