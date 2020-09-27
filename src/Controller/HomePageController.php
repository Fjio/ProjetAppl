<?php

namespace App\Controller;

use App\Repository\CampagneRepository;
use App\Repository\CandidatureRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HomePageController extends AbstractController
{

    /**
     * @Route("/home/page", name="app_homepage")
     */
    public function homePage() {
        $userRole = $this->get('security.token_storage')->getToken()->getUser()->getRoles()[0];
        switch ($userRole) {
            case "ROLE_ELEVE":
                return $this -> redirectToRoute('eleve_homepage');
                break;
            case "ROLE_PROFESSEUR":
                return $this -> redirectToRoute('prof_homepage');
                break;
            case "ROLE_ADMIN":
                return $this -> redirectToRoute('admin_homepage');
                break;
            default:
                break;
        }
    }

    /**
     * @IsGranted("ROLE_PROFESSEUR")
     * @Route("/home/prof", name="prof_homepage")
     * @param CandidatureRepository $candidatureRepository
     * @param CampagneRepository $campagneRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function profHomePage(CandidatureRepository $candidatureRepository, CampagneRepository $campagneRepository)
    {

        $idCampagneActuelle = $campagneRepository -> getIdCampagneActuelle();
        $idProfesseur = $this->get('security.token_storage')->getToken()->getUser()->getIdPersonne(); // Récupère l'id du professeur connecté
        $statsDossiersTraites = $candidatureRepository -> statsDossiersTraitesProf($idCampagneActuelle, $idProfesseur);
        return $this->render('prof/homepage.html.twig', ['statsDossiersTraites' => $statsDossiersTraites]);
    }

    /**
     * @IsGranted("ROLE_ELEVE")
     * @Route("/home/eleve", name="eleve_homepage")
     */
    public function eleveHomePage(): \Symfony\Component\HttpFoundation\Response
    {
        // A changer
        return $this->render('home_page/index.html.twig', ['controller_name' => 'test_homepage_eleve']);
    }

        /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/home/admin", name="admin_homepage")
     */
    public function adminHomePage(): \Symfony\Component\HttpFoundation\Response
    {
        // A changer
        return $this->render('administrateur_accueil/index.html.twig', []);
    }

}
