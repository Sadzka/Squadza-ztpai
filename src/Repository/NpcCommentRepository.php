<?php

namespace App\Repository;

use App\Entity\NpcComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NpcComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method NpcComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method NpcComment[]    findAll()
 * @method NpcComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NpcCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NpcComment::class);
    }

    // /**
    //  * @return NpcComment[] Returns an array of NpcComment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NpcComment
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
