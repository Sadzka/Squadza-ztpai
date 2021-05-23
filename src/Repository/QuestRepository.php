<?php

namespace App\Repository;

use App\Entity\Quest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Quest|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quest|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quest[]    findAll()
 * @method Quest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quest::class);
    }

    public function findQuests($name, $reqlvmin, $reqlvmax)
    {
        $name = '%' . $name . '%';
        if ($reqlvmin == '') $reqlvmin = 0;
        if ($reqlvmax == '') $reqlvmax = 9999;

        $query = $this->createQueryBuilder('a')
            ->andWhere('a.name LIKE :name')
            ->andWhere('a.required_level BETWEEN :reqlvmin and :reqlvmax')
            ->setParameter(':name', $name)
            ->setParameter(':reqlvmin', $reqlvmin)
            ->setParameter(':reqlvmax', $reqlvmax);

        return $query
            ->getQuery()
            ->getResult();
    }

    public function findLike($name) {
        if ($name == "") return [];
        $name = '%' . $name . '%';

        $query = $this->createQueryBuilder('a')
            ->andWhere('a.name LIKE :name')
            ->setParameter(':name', $name);

        return $query
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Quest[] Returns an array of Quest objects
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
    public function findOneBySomeField($value): ?Quest
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
