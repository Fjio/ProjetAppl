<?php

namespace App\Repository;

use App\Entity\NotesMatiere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method NotesMatiere|null find($id, $lockMode = null, $lockVersion = null)
 * @method NotesMatiere|null findOneBy(array $criteria, array $orderBy = null)
 * @method NotesMatiere[]    findAll()
 * @method NotesMatiere[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotesMatiereRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NotesMatiere::class);
    }

    public function notesEleve($idEleve, $idCampagne) {
        $qb = $this -> createQueryBuilder('n')
            -> Join('n.idCampagne', 'c') // Candidature
            -> Join('n.nomMatiere', 'm') // Matiere
            -> leftJoin('n.idOption', 'o') // Option
            -> where('c.idCampagne = :idCampagne')
            -> andWhere('c.idEleve = :idEleve')
            -> setParameter('idCampagne', $idCampagne)
            -> setParameter('idEleve', $idEleve)
            -> select('n, m, o');

        return $qb -> getQuery() -> getResult();
    }

}
