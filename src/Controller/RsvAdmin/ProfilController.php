<?php


namespace App\Controller\RsvAdmin;


use App\Entity\Comment;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProfilController
 * @package App\Controller\RsvAdmin
 * @Route("/dashboard/profil")
 */
class ProfilController extends AbstractController
{

    /**
     * Display current user topics
     * @Route("/my-topics", name="profil_topics", methods={"GET"})
     */
    public function myTopics()
    {
        # Get the current connected user
        /** @var User $user */
        $user = $this->getUser();

        # Get $user topics
        $topics = $user->getSuggestedTopics();

        # Transmit to view
        return $this->render('admin/profil/my-topics.html.twig', [
            'topics' => $topics
        ]);
    }

    /**
     * Display current user answers
     * @Route("/my-answers", name="profil_answers", methods={"GET"})
     */
    public function myAnswers()
    {
        # Get the current connected user
        /** @var User $user */
        $user = $this->getUser();

        # Get $user answers
        $answers = $user->getAnswers();

        # Transmit to view
        return $this->render('admin/profil/my-answers.html.twig', [
            'answers' => $answers
        ]);
    }

    /**
     * Display current user answers
     * @Route("/my-contributions", name="profil_contributions", methods={"GET"})
     */
    public function myContributions()
    {
        # Get the current connected user
        /** @var User $user */
        $user = $this->getUser();

        # Get $user contributions
        $contributions = $this->getDoctrine()
            ->getRepository(Comment::class)
            ->findBy([
               'user' => $user,
                'type' => 'private'
            ]);

        # Transmit to view
        return $this->render('admin/profil/my-contributions.html.twig', [
            'contributions' => $contributions
        ]);
    }
}