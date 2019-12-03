<?php


namespace App\Controller\RsvAdmin;


use App\Answer\AnswerRequest;
use App\Answer\AnswerRequestHandler;
use App\Entity\Topic;
use App\Form\Answer\AnswerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard")
 */
class AdminRsvController extends AbstractController
{

    /**
     * @Route("/", name="admin_dashboard", methods={"GET"})
     * @Security("is_granted('ROLE_MINISTRY')")
     */
    public function index()
    {
        return $this->render("admin/dashboard/index.html.twig");
    }

    /**
     * List all Rsv Topics
     * @Route("/topics", name="admin_topics", methods={"GET"})
     * @Security("is_granted('ROLE_MINISTRY')")
     */
    public function topics()
    {
        # Get all topics
        $topics = $this->getDoctrine()
            ->getRepository(Topic::class)
            ->findAll();

        # Transmit data to view
        return $this->render("admin/dashboard/topics.html.twig", [
            'topics' => $topics
        ]);
    }

    /**
     * Display one Topic
     * @Route("/topic/{id<\d+>}-{alias<[a-zA-Z0-9\-_\/]+>}.html", name="admin_topic", methods={"GET|POST"})
     * @Security("is_granted('ROLE_MINISTRY')")
     * @param Topic $topic
     * @param $alias
     * @param Request $request
     * @param AnswerRequestHandler $answerRequestHandler
     * @return Response
     */
    public function topic(Topic $topic,
                          string $alias,
                          Request $request,
                          AnswerRequestHandler $answerRequestHandler)
    {

        # Check topic is not null
        if (null === $topic) {
            return $this->redirectToRoute('admin_dashboard', [],
                Response::HTTP_MOVED_PERMANENTLY);
        }

        # Check SLUG
        if ($topic->getAlias() !== $alias) {
            return $this->redirectToRoute('admin_dashboard', [
                'alias' => $topic->getAlias(),
                'id' => $topic->getId()
            ]);
        }

        # Manage Answer Request
        $answerReq = $topic->getAnswer() === null
            ? new AnswerRequest($topic, $this->getUser())
            : AnswerRequest::createFromAnswer($topic->getAnswer());

        # Create Answer Form
        $form = $this->createForm(AnswerType::class, $answerReq)
            ->handleRequest($request);

        # Check form submission
        if ($form->isSubmitted() && $form->isValid()) {

            # Handle new Answer
            $answerReq->id === null
                ? $answerRequestHandler->handle($answerReq)
                : $answerRequestHandler->update($answerReq, $topic->getAnswer());

            # Add Flash
            $this->addFlash('notice',
                'Merci. Votre éclairage est enregistré.');

            # Redirect
            return $this->redirectToRoute('admin_topic', [
                'id' => $topic->getId(),
                'alias' => $topic->getAlias()
            ]);

        }

        # Transmit data to view
        return $this->render("admin/dashboard/topic.html.twig", [
            'topic' => $topic,
            'form' => $form->createView()
        ]);
    }

}
