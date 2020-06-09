<?php


namespace App\Controller\Rsv\Topic;


use App\Entity\Comment;
use App\Entity\Topic;
use App\Form\Comment\PublicCommentType;
use App\Form\Topic\AdminCommentType;
use App\Form\Topic\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CommentController
 * @package App\Controller\Rsv\Topic
 * @Route("/comment")
 */
class CommentController extends AbstractController
{
    /**
     * Generate Comment Form
     * @param int $topicId
     * @return Response
     */
    public function generateCommentForm(int $topicId)
    {
        # Create Form
        $form = $this->createForm(CommentType::class, [
            'topicId' => $topicId
        ], ['action' => $this->generateUrl('comment_private_add')]);

        # Transmit form to view
        return $this->render('rsv/comment/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Add new comment
     * @Route("/private/add", name="comment_private_add", methods={"POST"})
     * @Security("is_granted('ROLE_MINISTRY')")
     * @param Request $request
     * @return JsonResponse
     */
    public function addPrivateComment(Request $request)
    {

        # Get submitted data
        $commentRequest = $request->request->get('rsv_comment');

        # Get topic
        $topic = $this->getDoctrine()
            ->getRepository(Topic::class)
            ->find( $commentRequest['topicId'] );

        # Create new Comment
        $comment = new Comment();
        $comment->setContent($commentRequest['content'])
            ->setTopic($topic)
            ->setUser($this->getUser())
            ->setType('private');

        # Persist Data
        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();

        # TODO Event Emmit, notify topic's contributor Response user and topic creator.

        # Return JSON Data
        return $this->json([
            'status' => true,
            'comment' => [
                'content' => $comment->getContent(),
                'writingDate' => $comment->getWritingDate()
            ],
            'user' => [
                'firstname' => $comment->getUser()->getFirstname(),
                'lastname' => $comment->getUser()->getLastname()
            ]
        ]);
    }

    /**
     * Generate Admin Comment Form
     * @param int $topicId
     * @return Response
     */
    public function generateAdminCommentForm(int $topicId)
    {
        # Create Form
        $form = $this->createForm(AdminCommentType::class, [
            'topicId' => $topicId
        ], ['action' => $this->generateUrl('comment_admin_add')]);

        # Transmit form to view
        return $this->render('rsv/comment/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Add new admin comment
     * @Route("/admin/add", name="comment_admin_add", methods={"POST"})
     * @Security("is_granted('ROLE_MINISTRY')")
     * @param Request $request
     * @return JsonResponse
     */
    public function addAdminComment(Request $request)
    {

        # Get submitted data
        $commentRequest = $request->request->get('rsv_admin_comment');

        # Get topic
        $topic = $this->getDoctrine()
            ->getRepository(Topic::class)
            ->find( $commentRequest['topicId'] );

        # Create new Comment
        $comment = new Comment();
        $comment->setContent($commentRequest['content'])
            ->setTopic($topic)
            ->setUser($this->getUser())
            ->setType('admin');

        # Persist Data
        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();

        # TODO Event Emmit, notify topic's contributor Response user and topic creator.

        # Return JSON Data
        return $this->json([
            'status' => true,
            'comment' => [
                'content' => $comment->getContent(),
                'writingDate' => $comment->getWritingDate()
            ],
            'user' => [
                'firstname' => $comment->getUser()->getFirstname(),
                'lastname' => $comment->getUser()->getLastname()
            ]
        ]);
    }

    /**
     * Generate Public Comment Form
     * @param int $topicId
     * @return Response
     */
    public function generatePublicCommentForm(int $topicId)
    {
        # Create Form
        $form = $this->createForm(PublicCommentType::class, [
            'topicId' => $topicId
        ], ['action' => $this->generateUrl('xhr_comment')]);

        # Transmit form to view
        return $this->render('rsv/comment/public-form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Add new comment
     * @Route("/public/add", name="xhr_comment", methods={"POST"})
     * @Security("is_granted('ROLE_USER')")
     * @param Request $request
     * @return RedirectResponse
     */
    public function addPublicComment(Request $request)
    {

        # Get submitted data
        $commentRequest = $request->request->get('rsv_public_comment');

        # Get topic
        /** @var Topic $topic */
        $topic = $this->getDoctrine()
            ->getRepository(Topic::class)
            ->find( $commentRequest['topicId'] );

        # Create new Comment
        $comment = new Comment();
        $comment->setContent($commentRequest['content'])
            ->setTopic($topic)
            ->setUser($this->getUser())
            ->setVerse($commentRequest['verseText'])
            ->setType('public');

        # Persist Data
        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();

        # Redirect
        return $this->redirectToRoute('rsv_topic', [
           'category' => $topic->getCategory()->getAlias(),
           'alias'  => $topic->getAlias(),
           'id'  => $topic->getId(),
        ]);

    }
}