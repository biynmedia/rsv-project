<?php


namespace App\Controller\Rsv;


use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Topic;
use App\Entity\Verse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RsvController extends AbstractController
{

    /**
     * Page d'Accueil
     * @Route("/", name="rsv_home", methods={"GET"})
     */
    public function home()
    {

        # Get Doctrine Manager
        $rep = $this->getDoctrine()->getRepository(Topic::class);

        # Get last two published topics
        $topics = $rep->findLastTopics(2);

        # TODO Get trending post
        # TODO Get recent post except first 2

        return $this->render('rsv/home.html.twig', [
            'topics' => $topics
        ]);
    }


    /**
     * Display a Topic
     * @Route("/{category}/{alias}_{id}.html", name="rsv_topic", methods={"GET"})
     * @param Topic $topic
     * @param $alias
     * @param $category
     * @return RedirectResponse|Response
     */
    public function topic($alias, $category, Topic $topic = null)
    {

        # Redirect if ID not Found
        if ($topic === null) {
            return $this->redirectToRoute('rsv_home');
        }

        # Redirect if alias isn't correct
        if ($alias !== $topic->getAlias()) {
            return $this->redirectToRoute('rsv_topic', [
                'category' => $topic->getCategory()->getAlias(),
                'alias' => $topic->getAlias(),
                'id' => $topic->getId()
            ]);
        }

        # Redirect if category isn't correct
        if ($category !== $topic->getCategory()->getAlias()) {
            return $this->redirectToRoute('rsv_topic', [
                'category' => $topic->getCategory()->getAlias(),
                'alias' => $topic->getAlias(),
                'id' => $topic->getId()
            ]);
        }

        # Check user comment permission
        $userComment = null;
        if($this->getUser() && $topic) {
            $userComment = $this->getDoctrine()
                ->getRepository(Comment::class)
                ->findByUserAndTopic($this->getUser()->getId(), $topic->getId());
        }

        # Render View
        return $this->render('rsv/topic/topic.html.twig', [
           'topic' => $topic,
            'userComment' => $userComment
        ]);
    }

    /**
     * Render Verse, Instagram Area
     */
    public function instagram()
    {
        # Get Verses
        # TODO : Make Random
        $verses = $this->getDoctrine()->getRepository(Verse::class)
            ->findAll();

        return $this->render('components/_instagram-area.html.twig', [
            'verses' => $verses
        ]);

    }

    /**
     * Newsletter Subscribe
     */
    public function newsletter()
    {
        return $this->render('components/_newsletter.html.twig');
    }

    /**
     * Render Category
     */
    public function category()
    {
        # Get Categories
        $categories = $this->getDoctrine()->getRepository(Category::class)
            ->findAll();

        return $this->render('components/_category.html.twig', [
            'categories' => $categories
        ]);

    }

    /**
     * Get Latest Topics
     */
    public function latestTopics()
    {
        # Get topics TODO : Update with limit and order
        $topics = $this->getDoctrine()
            ->getRepository(Topic::class)
            ->findAll();

        # Render View
        return $this->render('components/_topics.html.twig', [
            'topics' => $topics
        ]);
    }

}