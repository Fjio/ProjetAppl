<?php

namespace App\Repository;

use App\Entity\PossibiliteOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PossibiliteOption|null find($id, $lockMode = null, $lockVersion = null)
 * @method PossibiliteOption|null findOneBy(array $criteria, array $orderBy = null)
 * @method PossibiliteOption[]    findAll()
 * @method PossibiliteOption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PossibiliteOptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PossibiliteOption::class);
    }

    public function listePossibilites($idCampagne){

        $qb = $this->createQueryBuilder('po')
        ->Join('po.idOption','o')
        ->Join('po.nomMatiere','m')
        ->Join('po.nomSection','s')
        ->Join('po.idCampagne','c')
        ->where('c.idCampagne =:idCampagne')
        ->setParameter('idCampagne', $idCampagne)
        ->select('m.nomMatiere')
        ->addSelect('s.nomSection')
        ->addSelect('o.acronymeOption')
        ->addSelect('po.coefdifferent')
        ->addSelect('po.idPossibiliteOption');

        return $qb->getQuery()->getArrayResult();
    }

    // /**
    //  * @return PossibiliteOption[] Returns an array of PossibiliteOption objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PossibiliteOption
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
