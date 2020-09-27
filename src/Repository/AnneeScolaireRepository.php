<?php

namespace App\Repository;

use App\Entity\AnneeScolaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AnneeScolaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnneeScolaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnneeScolaire[]    findAll()
 * @method AnneeScolaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnneeScolaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnneeScolaire::class);
    }

    /**
     * Récupère les années scolaires d'un élève pour une campagne donnée.
     * @param $idEleve
     * @param $idCampagne
     * @return AnneeScolaire[]
     */
    public function anneesScolairesEleve($idEleve, $idCampagne): array {
        $qb = $this -> createQueryBuilder('a')
            -> Join('a.idCampagne', 'c')  // Candidature
            -> where('c.idCampagne = :idCampagne')
            -> andWhere('c.idEleve= :idEleve')
            -> setParameter('idEleve', $idEleve)
            -> setParameter('idCampagne', $idCampagne)
            -> select('a')
            -> orderBy('a.annee','DESC');

        return $qb -> getQuery() -> getResult();
    }

    // /**
    //  * @return AnneeScolaire[] Returns an array of AnneeScolaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AnneeScolaire
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
