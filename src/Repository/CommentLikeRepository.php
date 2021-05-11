<?php

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\CommentLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommentLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentLike[]    findAll()
 * @method CommentLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentLike::class);
    }

    public function sumCommentLikes(Comment $comment) : int
    {
        $result = 
            $this->createQueryBuilder('a')
            ->select('SUM(a.value) as score')
            ->andWhere('a.comment = :val')
            ->setParameter('val', $comment)
            ->getQuery()
            ->getResult()[0]['score'];
        return $result ? $result : 0;
    }

    // /**
    //  * @return CommentLike[] Returns an array of CommentLike objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CommentLike
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
