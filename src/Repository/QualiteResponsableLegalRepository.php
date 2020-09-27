<?php

namespace App\Repository;

use App\Entity\QualiteResponsableLegal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method QualiteResponsableLegal|null find($id, $lockMode = null, $lockVersion = null)
 * @method QualiteResponsableLegal|null findOneBy(array $criteria, array $orderBy = null)
 * @method QualiteResponsableLegal[]    findAll()
 * @method QualiteResponsableLegal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QualiteResponsableLegalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QualiteResponsableLegal::class);
    }

    // /**
    //  * @return QualiteResponsableLegal[] Returns an array of QualiteResponsableLegal objects
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
    public function findOneBySomeField($value): ?QualiteResponsableLegal
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
