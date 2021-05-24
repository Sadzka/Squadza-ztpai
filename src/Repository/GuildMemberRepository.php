<?php

namespace App\Repository;

use App\Entity\GuildMember;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method GuildMember|null find($id, $lockMode = null, $lockVersion = null)
 * @method GuildMember|null findOneBy(array $criteria, array $orderBy = null)
 * @method GuildMember[]    findAll()
 * @method GuildMember[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GuildMemberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GuildMember::class);
    }

    public function countMembers($guild)
    {
        return $this->createQueryBuilder('a')
            ->select('COUNT(a.member) as members')
            ->andWhere('a.guild = :guild')
            ->setParameter('guild', $guild)
            ->getQuery()
            ->getResult()[0]['members'];
    }
    public function averageLevel($guild)
    {
        $qb = $this->createQueryBuilder('a');

        $qb->select('AVG(m.level) as level')
            ->innerJoin('a.member', 'm', Join::ON)

            ->andWhere('a.guild = :guild')
            ->setParameter(':guild', $guild);

        return $qb
            ->getQuery()
            ->getResult()[0]['level'];

    }

    // /**
    //  * @return GuildMember[] Returns an array of GuildMember objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GuildMember
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
