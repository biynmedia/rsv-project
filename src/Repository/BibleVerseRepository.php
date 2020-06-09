<?php

namespace App\Repository;

use App\Entity\BibleVerse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BibleVerse|null find($id, $lockMode = null, $lockVersion = null)
 * @method BibleVerse|null findOneBy(array $criteria, array $orderBy = null)
 * @method BibleVerse[]    findAll()
 * @method BibleVerse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BibleVerseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BibleVerse::class);
    }

    /**
     * @param int $bookId
     * @return BibleVerse[] Returns an array of BibleVerse objects
     */
    public function findChaptersByBookId(int $bookId)
    {
        return $this->createQueryBuilder('bv')
            ->select('bv.chapter')
            ->andWhere('bv.bookNumber = :bookId')
            ->setParameter('bookId', $bookId)
            ->distinct()
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param int $bookId
     * @param int $chapterId
     * @return BibleVerse[] Returns an array of BibleVerse objects
     */
    public function findVersesByBookIdAndChapterId(int $bookId, int $chapterId)
    {
        return $this->createQueryBuilder('bv')
            ->andWhere('bv.bookNumber = :bookId')
            ->setParameter('bookId', $bookId)
            ->andWhere('bv.chapter = :chapterId')
            ->setParameter('chapterId', $chapterId)
            ->getQuery()
            ->getResult()
            ;
    }


    /*
    public function findOneBySomeField($value): ?BibleVerse
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
