<?php


namespace App\Controller\Rsv;


use App\Entity\Category;
use App\Entity\Topic;
use App\Entity\Verse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

}