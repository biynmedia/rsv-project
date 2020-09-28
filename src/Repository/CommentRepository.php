<?php

namespace App\Repository;

use App\Comment\Dbal\EnumCommentType;
use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    /**
     * @param int $userId
     * @param int $topicId
     * @return Comment[] Returns a Comment objects
     * @throws NonUniqueResultException
     */
    public function findByUserAndTopic(int $userId, int $topicId)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.user = :userId')
            ->setParameter('userId', $userId)
            ->andWhere('c.topic = :topicId')
            ->setParameter('topicId', $topicId)
            ->andWhere('c.type = :commentType')
            ->setParameter('commentType', EnumCommentType::STATUS_PUBLIC)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Comment
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
