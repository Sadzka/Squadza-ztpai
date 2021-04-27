<?php

namespace App\Repository;
use App\Entity\ArticleComment;
use App\Entity\ArticleCommentLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/*
use Doctrine\ORM\EntityRepository;
use App\Entity\ArticleComment;
use App\Entity\ArticleCommentLike;

class ArticleCommentLikeRepository extends EntityRepository
{
    public function sumCommentLikes(ArticleComment $comment) : int
    {
        return
            $this->getDoctrine()->getRepository(ArticleCommentLike::class)->createQueryBuilder('a')
            ->select('SUM(a.value) as score')
            ->andWhere('a.articleComment = :val')
            ->setParameter('val', $comment)
            ->getQuery()
            ->getResult()[0]['score'];
    }
}*/

/**
 * @method ArticleCommentLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticleCommentLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticleCommentLike[]    findAll()
 * @method ArticleCommentLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method int                     sumCommentLikes(ArticleComment $comment)
 */
class ArticleCommentLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticleCommentLike::class);
    }

    public function sumCommentLikes(ArticleComment $comment) : int
    {
        $result = 
            $this->createQueryBuilder('a')
            ->select('SUM(a.value) as score')
            ->andWhere('a.articleComment = :val')
            ->setParameter('val', $comment)
            ->getQuery()
            ->getResult()[0]['score'];
        return $result ? $result : 0;
    }


    // /**
    //  * @return ArticleCommentLike[] Returns an array of ArticleCommentLike objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ArticleCommentLike
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
