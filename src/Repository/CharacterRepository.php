<?php

namespace App\Repository;

use App\Entity\Character;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Character|null find($id, $lockMode = null, $lockVersion = null)
 * @method Character|null findOneBy(array $criteria, array $orderBy = null)
 * @method Character[]    findAll()
 * @method Character[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Character::class);
    }

    public function findCharacters($name, $lvmin, $lvmax)
    {
        $name = '%' . $name . '%';
        if ($lvmin == '') $lvmin = 0;
        if ($lvmax == '') $lvmax = 9999;

        $query = $this->createQueryBuilder('a')
            ->andWhere('a.name LIKE :name')
            ->andWhere('a.level BETWEEN :lvmin and :lvmax')
            ->setParameter(':name', $name)
            ->setParameter(':lvmin', $lvmin)
            ->setParameter(':lvmax', $lvmax);

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
    //  * @return Character[] Returns an array of Character objects
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
    public function findOneBySomeField($value): ?Character
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
