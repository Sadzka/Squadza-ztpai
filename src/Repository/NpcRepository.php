<?php

namespace App\Repository;

use App\Entity\Npc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Npc|null find($id, $lockMode = null, $lockVersion = null)
 * @method Npc|null findOneBy(array $criteria, array $orderBy = null)
 * @method Npc[]    findAll()
 * @method Npc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NpcRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Npc::class);
    }

    public function findNpcs($name, $lvmin, $lvmax, $locations)
    {
        $locations_id = [];
        foreach ($locations as $location) {
            array_push($locations_id, $location->getId());
        }

        $name = '%' . $name . '%';
        if ($lvmin == '') $lvmin = 0;
        if ($lvmax == '') $lvmax = 9999;

        $query = $this->createQueryBuilder('a')
            ->andWhere('a.name LIKE :name')
            ->andWhere('a.level BETWEEN :lvmin and :lvmax')
            ->setParameter(':name', $name)
            ->setParameter(':lvmin', $lvmin)
            ->setParameter(':lvmax', $lvmax);

        if ($locations_id != []) {
            $query
                ->andWhere("a.location IN (:location)")
                ->setParameter(":location", $locations_id);
        }


        //var_dump($query->getQuery()->getSQL());
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
    //  * @return Npc[] Returns an array of Npc objects
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
    public function findOneBySomeField($value): ?Npc
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
