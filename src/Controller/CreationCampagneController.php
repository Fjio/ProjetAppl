<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \DateTime;
use App\Entity\Campagne;
use App\Entity\Calendrier;
use App\Entity\Section;
use App\Entity\Coefficient;
use App\Entity\Matiere;
use App\Entity\Option;
use App\Entity\PossibiliteOption;
use App\Repository\CampagneRepository;
use App\Repository\SectionRepository;
use App\Repository\MatiereRepository;
use App\Repository\CoefficientRepository;
use App\Repository\OptionRepository;
use App\Repository\PossibiliteOptionRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class CreationCampagneController extends AbstractController
{
    /**
     * @Route("/creation/campagne", name="creation_campagne")
     */
    public function index(SectionRepository $sectionRepository, MatiereRepository $matiereRepository)
    {
        return $this->render('creation_campagne/index.html.twig', [
        'sections' => $sectionRepository->findAll(),
        'matieres' => $matiereRepository->findAll()]);
    }

    /**
     * @Route("/choix/matieres/{idCampagne}", name="choix_matieres")
     */
    public function choixMatieres(SectionRepository $sectionRepository, MatiereRepository $matiereRepository, CoefficientRepository $coefficientRepository, $idCampagne)
    {
        return $this->render('creation_campagne/choixMatieres.html.twig', [
        'sections' => $sectionRepository->findAll(),
        'matieres' => $matiereRepository->findAll(),
        'coefficients' => $coefficientRepository->coefficientsCampagne($idCampagne),
        'idCampagne' => $idCampagne]);
    }

    /**
     * @Route("ajoutElectifs/{idCampagne}", name="ajoutElectifs")
     */
    public function ajoutElectifs(CoefficientRepository $coefficientRepository, OptionRepository $optionRepository, PossibiliteOptionRepository $possibiliteOptionRepository, $idCampagne)
    {
        return $this->render('creation_campagne/ajoutElectifs.html.twig', [
            'matieres' => $coefficientRepository->coefficientsCampagne($idCampagne),
            'options' => $optionRepository->listeOptions(),
            'specialites' => $optionRepository->listeSpecialites(),
            'possibilites' => $possibiliteOptionRepository->listePossibilites($idCampagne),
            'idCampagne' => $idCampagne
        ]);
    }


    /**
     * @Route("/ajoutCampagne", name="ajoutCampagne")
     */
    public function ajoutCampagne(Request $request) :Response{
        
        $em = $this->getDoctrine()->getManager();
        $sectionRepository = $this->getDoctrine()->getRepository(Section::class);

        $annee = $request->request->get('annee');
        $coefMG = $request->request->get('coefMG');
        $maxMG = $request->request->get('maxMG');
        $coefAB = $request->request->get('coefAB');
        $maxAB = $request->request->get('maxAB');
        $coefAD = $request->request->get('coefAD');
        $maxAD = $request->request->get('maxAD');
        
        $newCampagne = new Campagne();
        $newCampagne->setAnnee($annee);
        $newCampagne->setCoefNoteMoyenneGenerale($coefMG);
        $newCampagne->setNoteMaxMoyenneGenerale($maxMG);
        $newCampagne->setCoefNoteAutobiographie($coefAB);
        $newCampagne->setNoteMaxAutobiographie($maxAB);
        $newCampagne->setCoefNoteAppreciationDossier($coefAD);
        $newCampagne->setNoteMaxAppreciationDossier($maxAD);
        $em->persist($newCampagne);

        $ouvCan = new DateTime($request->request->get("ouvCan"));
        $newOuvCan = new Calendrier();
        $newOuvCan->setCodeJalon("ouverture_candidature");
        $newOuvCan->setDate($ouvCan);
        $newOuvCan->setIdCampagne($newCampagne);
        $em->persist($newOuvCan);

        $ferCan = new DateTime($request->request->get('ferCan'));
        $newFerCan = new Calendrier();
        $newFerCan->setCodeJalon("fermeture_candidature");
        $newFerCan->setDate($ferCan);
        $newFerCan->setIdCampagne($newCampagne);
        $em->persist($newFerCan);

        $resAdmissibilite = new DateTime ($request->request->get('resAdmissibilite'));
        $newResAdmissibilite = new Calendrier();
        $newResAdmissibilite->setCodeJalon("resultat_admissibilite");
        $newResAdmissibilite->setDate($resAdmissibilite);
        $newResAdmissibilite->setIdCampagne($newCampagne);
        $em->persist($newResAdmissibilite);

        $resAdmission = new DateTIme($request->request->get('resAdmission'));
        $newResAdmission = new Calendrier();
        $newResAdmission->setCodeJalon("resultat_admission");
        $newResAdmission->setDate($resAdmission);
        $newResAdmission->setIdCampagne($newCampagne);
        $em->persist($newResAdmission);
        

        $em->flush();

        return $this->redirectToRoute('choix_matieres', ['idCampagne' => $newCampagne->getIdCampagne()]);
    }

    /**
     * @Route("/supprimerCoefficient/{idCampagne}/{id}", name="supprimerCoefficient")
     */
    public function supprimerCoefficient(Coefficient $myCoefficient, $idCampagne): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($myCoefficient);
        $manager->flush();
        return $this->redirectToRoute('choix_matieres', ['idCampagne' => $idCampagne]);
    }

    /**
     * @Route("/ajoutCoefficient/{idCampagne}/{nomSection}", name="ajoutCoefficient")
     */
    public function ajoutCoefficient(Request $request, $idCampagne, $nomSection): Response 
    {
        $campagneRepository = $this->getDoctrine()->getRepository(Campagne::class);
        $matiereRepository = $this->getDoctrine()->getRepository(Matiere::class);
        $sectionRepository = $this->getDoctrine()->getRepository(Section::class);
        
        $nomMatiere = $request->request->get('matiere');
        $matiere = $matiereRepository->find($nomMatiere);
        $valeur = $request->request->get('coeff');
        $campagne = $campagneRepository->find($idCampagne);
        $section = $sectionRepository->find($nomSection);

        $coefficient = new Coefficient();
        $coefficient->setIdCampagne($campagne);
        $coefficient->setNomSection($section);
        $coefficient->setValeur((float)$valeur);
        $coefficient->setNomMatiere($matiere);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($coefficient);
        $manager->flush();
        return $this->redirectToRoute('choix_matieres', ['idCampagne' => $idCampagne]);
    }

    /**
     * @Route("/supprimerOption/{idCampagne}/{id}", name="supprimerOption")
     */
    public function supprimerOption(PossibiliteOption $myPossibiliteOption, $idCampagne): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($myPossibiliteOption);
        $manager->flush();
        return $this->redirectToRoute('ajoutElectifs', ['idCampagne' => $idCampagne]);
    }

        /**
     * @Route("/ajoutOption/{idCampagne}/{nomSection}/{nomMatiere}", name="ajoutOption")
     */
    public function ajoutOption(Request $request, $idCampagne, $nomSection, $nomMatiere): Response 
    {
        $campagneRepository = $this->getDoctrine()->getRepository(Campagne::class);
        $matiereRepository = $this->getDoctrine()->getRepository(Matiere::class);
        $sectionRepository = $this->getDoctrine()->getRepository(Section::class);
        $optionRepository = $this->getDoctrine()->getRepository(Option::class);
        
        $idOption = $request->request->get('idOption');
        $coefdifferent = $request->request->get('coeffdifferent');
        $matiere = $matiereRepository->find($nomMatiere);
        $campagne = $campagneRepository->find($idCampagne);
        $section = $sectionRepository->find($nomSection);
        $option = $optionRepository->find($idOption);

        $possibiliteOption = new PossibiliteOption();
        if ($coefdifferent != "") {
            $possibiliteOption->setCoefdifferent((float)$coefdifferent);
        }
        $possibiliteOption->setIdCampagne($campagne);
        $possibiliteOption->setNomSection($section);
        $possibiliteOption->setNomMatiere($matiere);
        $possibiliteOption->setIdOption($option);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($possibiliteOption);
        $manager->flush();
        return $this->redirectToRoute('ajoutElectifs', ['idCampagne' => $idCampagne]);
    }

}
