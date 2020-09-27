<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EleveRepository;

class EtudiantAccueilController extends AbstractController
{


    /**
     * @Route("/etudiant/accueil", name="etudiant_accueil")
     */
    public function index()
    {
        return $this->render('etudiant_accueil/index.html.twig', [
            'controller_name' => 'EtudiantAccueilController',
            'displayCalendar' => 'Hello world'
        ]);
    }


    /*
    public function badou() {
        $qb= $this->createQueryBuilder('a');
        $qb -> Join(association,alias);
            -> select('a.*');
        return $qb->getQuery()->getArrayResult();

    }

    public function index():Response {
        return $this->render(['truc',badou()]);
    }
    */

}
