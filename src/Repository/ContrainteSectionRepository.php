<?php

namespace App\Repository;

use App\Entity\ContrainteSection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ContrainteSection|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContrainteSection|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContrainteSection[]    findAll()
 * @method ContrainteSection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContrainteSectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContrainteSection::class);
    }

    // /**
    //  * @return ContrainteSection[] Returns an array of ContrainteSection objects
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
    public function findOneBySomeField($value): ?ContrainteSection
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
