<?php

namespace App\Repository;

use App\Entity\Candidature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Candidature|null find($id, $lockMode = null, $lockVersion = null)
 * @method Candidature|null findOneBy(array $criteria, array $orderBy = null)
 * @method Candidature[]    findAll()
 * @method Candidature[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Candidature::class);
    }
    
    //QueryBuilder récupérant tous les dossiers présents dans la base de données
    public function dossiers() {
        $qb = $this
            ->createQueryBuilder('c')
            ->Join('c.idEleve','e')
            ->Join('e.idPersonne','p')
            ->orderBy('p.idPersonne','ASC');
        return $qb;
    }

    //QueryBuilder récupérant tous les dossiers d'une campagne
    public function dossiersCampagne($idCampagne){
        $qb = $this
            ->dossiers()
            ->Join('c.idCampagne', 'cam')
            ->where('cam.idCampagne =:idCampagne')
            ->setParameter('idCampagne', $idCampagne);
        return $qb;
    }

    //Récupération de tous les dossiers d'une campagne dans un tableau
    public function listeDossiersCampagne($idCampagne){
        $qb = $this
        ->dossiersCampagne($idCampagne)
        ->select('cam.idCampagne')
        ->addSelect('p.idPersonne')
        ->addSelect('p.prenom as prenomEleve')
        ->addSelect('p.nom as nomEleve')
        ->addSelect('e.idEleve')
        ->addSelect('c.estTraite')
        ->addSelect('c.numeroDossier')
        ->leftJoin('c.idProfAssigne', 'prof')
        ->addSelect('prof.nom as nomProf')
        ->addSelect('prof.prenom as prenomProf');
        return $qb->getQuery()->getArrayResult();
    }

    /**
     * QueryBuilder pour récupérer la liste des dossiers attribués à un prof pour la campagne spécifiée.
     * @param $idCampagne L'id de la campagne.
     * @param $idPersonne L'id du professeur.
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function queryListeDossiersProf($idCampagne, $idPersonne) {
        $qb = $this
            -> dossiersCampagne($idCampagne)
            -> andWhere('c.idProfAssigne = :idPersonne')
            -> setParameter('idPersonne', $idPersonne);

        return $qb;
    }

    /**
     * La liste des dossiers attribués à un prof pour la campagne spécifiée.
     * @param $idCampagne L'id de la campagne.
     * @param $idPersonne L'id du professeur.
     * @return array
     */
    public function listeDossiersProf($idCampagne, $idPersonne) {
        $q = $this -> queryListeDossiersProf($idCampagne, $idPersonne);
        $q -> select('c.numeroDossier, e.idEleve, c.estTraite, c.noteMoyenneGenerale, c.noteAutobiographie, 
                            c.noteAppreciationDossier');

        return $q -> getQuery() -> getArrayResult();
    }

    /**
     * Renvoie le nombre de dossiers à traiter et le nombre de dossiers traités pour un prof pendant une campagne.
     * @param $idCampagne L'id de la campagne.
     * @param $idPersonne L'id du professeur.
     * @return array Tableau contenant 'nb_dossiers' et 'nb_traites'
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function statsDossiersTraitesProf($idCampagne, $idPersonne) {
        $dossiers = $this -> queryListeDossiersProf($idCampagne, $idPersonne)
            -> select('e.idEleve')
            -> getQuery() -> getArrayResult();

        $dossiersTraites = $this -> queryListeDossiersProf($idCampagne, $idPersonne)
            -> andWhere('c.estTraite = true')
            -> select('e.idEleve')
            -> getQuery() -> getArrayResult();

        if (isset($dossiers) && isset($dossiersTraites)) {
            return ['nb_dossiers' => count($dossiers), 'nb_traites' => count($dossiersTraites)];
        }
    }

    /**
     * Récupère le dossier administratif d'un élève.
     * @param $idEleve
     * @param $idCampagne
     * @return mixed Le dossier d'un élève ou null s'il n'existe pas.
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function dossierEleve($idEleve, $idCampagne) {
        $qb = $this -> dossiersCampagne($idCampagne)
            -> andWhere('e.idEleve = :idEleve')
            -> setParameter('idEleve', $idEleve)
            -> select('c, e, p'); // Campagne, Eleve, Personne

        return $qb -> getQuery() -> getOneOrNullResult();
    }

    //Récupération des dossiers traités d'une campagne dans un tableau
    public function listeDossiersTraitesCampagne($idCampagne){
        $qb = $this
        ->dossiersCampagne($idCampagne)
        ->select('p.idPersonne')
        ->addSelect('p.prenom')
        ->addSelect('p.nom')
        ->addSelect('c.estTraite')
        ->andWhere('c.estTraite =:vrai')
        ->addSelect('c.numeroDossier')
        ->setParameter('vrai', true);
        return $qb->getQuery()->getArrayResult();
    }

    //Fonction récupérant le nombre de dossiers dans la campagne 
    public function nombreDossiersCampagne($idCampagne){
        return count($this->listeDossiersCampagne($idCampagne));
    }

    //Fonction récupérant le nombre de dossiers traités dans la campagne 
    public function nombreDossiersTraitesCampagne($idCampagne){
        return count($this->listeDossiersTraitesCampagne($idCampagne));
    }




    // /**
    //  * @return Candidature[] Returns an array of Candidature objects
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
    public function findOneBySomeField($value): ?Candidature
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
