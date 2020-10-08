<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Utilisateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Utilisateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utilisateur[]    findAll()
 * @method Utilisateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);

    }

    public function listeProfs() {
        $qb = $this
        ->createQueryBuilder('u')
        ->Join('u.idPersonne', 'p')
        ->andWhere('u.roles =:role')
        ->setParameter('role', "ROLE_PROFESSEUR")
        ->select('p.nom')
        ->addSelect('p.prenom')
        ->addSelect('p.idPersonne');

        return $qb->getQuery()->getArrayResult();
    }

     /**
     * @return Utilisateur Returns a Utilisateur object
      */
    public function findByToken(string $token)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.token = :val')
            ->setParameter('val', $token)
            ->select('u.username')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }
    public function verifyUser(string $token)
    {
        $qb = $this->createQueryBuilder('u');
        $q = $qb 
            ->update('App\Entity\Utilisateur','u')
            ->set('u.validatedUser', 'TRUE')
            ->Where('u.token = :val')
            ->setParameter('val', $token)
            ->getQuery();

        $p = $q->execute();
        ;
    }
    /*
    public function findOneBySomeField($value): ?Utilisateur
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
