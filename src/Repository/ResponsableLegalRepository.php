<?php

namespace App\Repository;

use App\Entity\ResponsableLegal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ResponsableLegal|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResponsableLegal|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResponsableLegal[]    findAll()
 * @method ResponsableLegal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponsableLegalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResponsableLegal::class);
    }

    // /**
    //  * @return ResponsableLegal[] Returns an array of ResponsableLegal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ResponsableLegal
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
