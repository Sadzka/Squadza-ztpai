<?php

namespace App\Repository;

use App\Entity\QuestComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QuestComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestComment[]    findAll()
 * @method QuestComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestComment::class);
    }

    // /**
    //  * @return QuestComment[] Returns an array of QuestComment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QuestComment
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
