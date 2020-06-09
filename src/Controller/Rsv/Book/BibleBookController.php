<?php


namespace App\Controller\Rsv\Book;


use App\Entity\BibleVerse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BibleBookController extends AbstractController
{
    /**
     * Returns a JSON string with the verses of a book
     * @Route("/api/chapters", name="xhr_book_chapters", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function chapters(Request $request)
    {
        // Get Entity manager and repository
        $bookId = $request->get('bookId');
        $chapters = $this->getDoctrine()
            ->getRepository(BibleVerse::class)
            ->findChaptersByBookId($bookId);

        $responseArray = array();

        /** @var BibleVerse $chapter */
        foreach($chapters as $chapter){
            $responseArray[] = array(
                "id" => $chapter['chapter'],
                "name" => 'Chapitre ' . $chapter['chapter']
            );
        }

        // Return array with structure of the verse of the providen book id
        return new JsonResponse($responseArray);
    }

    /**
     * Returns a JSON string with the verses of a book
     * @Route("/api/verses", name="xhr_book_verses", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function verses(Request $request)
    {
        # Get Book and Chapter Id from Request
        $bookId = $request->get('bookId');
        $chapterId = $request->get('chapterId');

        # Get Verses
        $verses = $this->getDoctrine()
            ->getRepository(BibleVerse::class)
            ->findVersesByBookIdAndChapterId($bookId, $chapterId);

        $responseArray = array();

        /** @var BibleVerse $verse */
        foreach($verses as $verse){
            $responseArray[] = array(
                "id" => $verse->getVerse(),
                "name" => 'Verset ' . $verse->getVerse(),
                "text" => strip_tags($verse->getText())
            );
        }

        // Return array with structure of the verse of the providen book id
        return new JsonResponse($responseArray);
    }
}