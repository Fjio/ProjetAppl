<?php

namespace App\Repository;

use App\Entity\Coefficient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Coefficient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Coefficient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Coefficient[]    findAll()
 * @method Coefficient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoefficientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coefficient::class);
    }

    public function coefficientsCampagne($idCampagne) {
        $qb = $this->createQueryBuilder('c')
        ->where('c.idCampagne =:idCampagne')
        ->setParameter('idCampagne', $idCampagne)
        ->Join('c.nomMatiere', 'm')
        ->Join('c.nomSection', 's')
        ->select('c.valeur')
        ->addSelect('c.idCoefficient')
        ->addSelect('m.nature')
        ->addSelect('m.nomMatiere')
        ->addSelect('s.nomSection');
        return $qb->getQuery()->getArrayResult();
    }

    // /**
    //  * @return Coefficient[] Returns an array of Coefficient objects
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
    public function findOneBySomeField($value): ?Coefficient
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
