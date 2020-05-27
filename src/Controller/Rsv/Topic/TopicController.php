<?php


namespace App\Controller\Rsv\Topic;


use App\Entity\Topic;
use App\Form\Topic\TopicType;
use App\Topic\TopicRequest;
use App\Topic\TopicRequestHandler;
use App\Upload\UploadManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/topic")
 */
class TopicController extends AbstractController
{
    /**
     * Create a new Topic
     * @Route("/create", name="topic_create", methods={"GET|POST"})
     * @Security("is_granted('ROLE_MINISTRY')")
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
     * @Route("/edit/{id}", name="topic_edit", methods={"GET|POST"})
     * @Security("(topic.getStatus() != 'published' and topic.isWriter(user) and is_granted('ROLE_MINISTRY')) or is_granted('ROLE_ADMIN')")
     * @param Topic $topic
     * @param Request $request
     * @param Packages $packages
     * @param TopicRequestHandler $topicRH
     * @return RedirectResponse|Response
     */
    public function editTopic(
        Topic $topic,
        Request $request,
        Packages $packages,
        TopicRequestHandler $topicRH)
    {

        # Create new Topic Request
        $topicReq = TopicRequest::createFromTopic(
            $topic,
            $this->getParameter('upload_directory'),
            $packages
        );

        # Create form
        $options = [
            'image_url' => $topicReq->imageUrl
        ];

        $form = $this->createForm(TopicType::class, $topicReq, $options)
            ->handleRequest($request);

        # Check form submission
        if ($form->isSubmitted() && $form->isValid()) {

            # Handle Topic Workflow
            $topic = $topicRH->update($topicReq, $topic);

            # Add Flash
            $this->addFlash('notice',
                'Modification enregistré.');

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
     * Delete a Topic
     * @Route("/delete/{id}", name="topic_delete", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN')")
     * @param Topic $topic
     * @param UploadManager $uploadManager
     * @return RedirectResponse
     */
    public function deleteTopic(Topic $topic, UploadManager $uploadManager)
    {
        # Remove images
        $uploadManager->deleteUploadedFile($topic->getImage());
        $uploadManager->deleteUploadedFile($topic->getImage(), 120);
        $uploadManager->deleteUploadedFile($topic->getImage(), 250);
        $uploadManager->deleteUploadedFile($topic->getImage(), 370);
        $uploadManager->deleteUploadedFile($topic->getImage(), 470);

        # Remove from doctrine
        $em = $this->getDoctrine()->getManager();
        $em->remove($topic);
        $em->flush();

        # Return confirmation message
        $this->addFlash('notice',
            'Ce sujet a bien été supprimé.');

        # Redirect to topics page
        return $this->redirectToRoute('admin_topics');
    }
}