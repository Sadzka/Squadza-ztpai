<?php

namespace App\Repository;

use App\Entity\ItemComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ItemComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemComment[]    findAll()
 * @method ItemComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemComment::class);
    }

    // /**
    //  * @return ItemComment[] Returns an array of ItemComment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ItemComment
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
