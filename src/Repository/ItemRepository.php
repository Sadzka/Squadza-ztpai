<?php

namespace App\Repository;

use App\Entity\Item;
use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Item|null find($id, $lockMode = null, $lockVersion = null)
 * @method Item|null findOneBy(array $criteria, array $orderBy = null)
 * @method Item[]    findAll()
 * @method Item[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }

    public function findItems(
        $name       = '',
        $ilvmin     = 1,
        $ilvmax     = 9999,
        $reqlvmin   = 1,
        $reqlvmax   = 9999,
        $slots       = [],
        $rarities     = []
    ) {
        $name = '%'.$name.'%';
        if ($ilvmin == '') $ilvmin = 0;
        if ($ilvmax == '') $ilvmax = 9999;
        if ($reqlvmin == '') $reqlvmin = 0;
        if ($reqlvmax == '') $reqlvmax = 9999;
        if ($slots == '') $slots = [];
        if ($rarities == '') $rarities = [];

        $query = $this->createQueryBuilder('a')
            ->andWhere('a.name LIKE :name')
            ->andWhere('a.item_level BETWEEN :ilvmin and :ilvmax')
            ->andWhere('a.required_level BETWEEN :reqlvmin and :reqlvmax')
            ->setParameter(':name', $name)
            ->setParameter(':ilvmin', $ilvmin)
            ->setParameter(':ilvmax', $ilvmax)
            ->setParameter(':reqlvmin', $reqlvmin)
            ->setParameter(':reqlvmax', $reqlvmax);

        if ($slots != []) {
            $query
                ->andWhere('a.slot IN (:slots)')
                ->setParameter('slots', $slots);
        }
        if ($rarities != []) {
            $query
                ->andWhere('a.quality IN (:rarities)')
                ->setParameter('rarities', $rarities);
        }

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
    //  * @return Item[] Returns an array of Item objects
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
    public function findOneBySomeField($value): ?Item
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
