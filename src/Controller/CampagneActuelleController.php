<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CandidatureRepository;
use App\Repository\CampagneRepository;
use App\Entity\Candidature;
use App\Repository\CalendrierRepository;
use App\Repository\NotesMatiereRepository;
use App\Repository\AnneeScolaireRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\PersonneRepository;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\PositiveOrZero;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class CampagneActuelleController extends AbstractController
{
    /**
     * @Route("/campagne/actuelle", name="campagne_actuelle")
     */
    public function index(CandidatureRepository $candidatureRepository, CampagneRepository $campagneRepository, CalendrierRepository $calendrierRepository): Response
    {
        $idCampagneActuelle = $campagneRepository->getIdCampagneActuelle();
        $campagneActuelle = $campagneRepository->findOneByIdCampagne($idCampagneActuelle);
        $nombreDeDossiers = $candidatureRepository->nombreDossiersCampagne($idCampagneActuelle);
        $nombreDeDossiersTraites = $candidatureRepository->nombreDossiersTraitesCampagne($idCampagneActuelle); 
        $dossiers = $candidatureRepository->listeDossiersCampagne($idCampagneActuelle);
        $calendriers = $calendrierRepository->listeDatesCampagne($idCampagneActuelle);

        return $this->render('campagne_actuelle/index.html.twig',
            ['nombreDeDossiers' => $nombreDeDossiers,
            'nombreDeDossiersTraites' => $nombreDeDossiersTraites,
            'dossiers' => $dossiers,
            'campagneActuelle' => $campagneActuelle,
            'calendriers' => $calendriers
            ]);
    }

    /**
     * @Route("/modifierDossier/{idCampagne}/{idEleve}", name="modifierDossier")
     */
    public function modifierDossier(CandidatureRepository $candidatureRepository, NotesMatiereRepository $notesMatiereRepository, AnneeScolaireRepository $anneeScolaireRepository, UtilisateurRepository $utilisateurRepository ,$idCampagne, $idEleve): Response 
    {
        $dossier = $candidatureRepository->dossierEleve($idEleve, $idCampagne); // calcul du dossier du candidat Personne dans le Repository Candidature
        $notes = $notesMatiereRepository->notesEleve($idEleve, $idCampagne);
        $anneesScolaires = $anneeScolaireRepository->anneesScolairesEleve($idEleve, $idCampagne);
        $profs = $utilisateurRepository->listeProfs();

        return $this -> render('campagne_actuelle/modificationDossier.html.twig',
        ['dossier' => $dossier,
        'notes' => $notes, 
        'anneesScolaires' => $anneesScolaires,
        'idEleve' => $idEleve,
        'profs' => $profs,
        'idCampagne' => $idCampagne]);
    }

         /**
         * @Route("/assignationProf/{idCampagne}/{idEleve}", name="assignationProf")
         */
        public function assignationProf(Request $request, CandidatureRepository $candidatureRepository, PersonneRepository $personneRepository ,$idCampagne, $idEleve): Response{
            $em = $this->getDoctrine()->getManager();
            $dossier = $candidatureRepository->dossierEleve($idEleve, $idCampagne);
            $idProf = $request->request->get('profassigne');
            $prof = $personneRepository->find($idProf);
            $dossier->setIdProfAssigne($prof);
            $em->persist($dossier);
            $em->flush();
            return $this->redirectToRoute('modifierDossier', ['idCampagne' => $idCampagne, 'idEleve' => $idEleve]);
        }

    /**
     * @Route("/evaluerCandidatAdmin", name="evaluerCandidatAdmin")
     * Ce code est une dupplication du code de la version professeur 
     * Il faudra factoriser le code
     */
    public function evaluerCandidatAdmin(Request $request, CampagneRepository $campagneRepository, CandidatureRepository $candidatureRepository,
        $idEleve=null, $idCampagne=null) {
        // Récupère l'id de l'élève à noter
        if (!empty($idEleve)) { // Quand le form est généré
        $idEleve = intval($idEleve);
        } else { // Quand le form est validé
        $idEleve = intval($request -> request -> get('form')['idEleve']);
        }

        // Récupère l'id de la campagne
        if (!empty($idCampagne)) { // Quand le form est généré
        $idCampagne = intval($idCampagne);
        } else { // Quand le form est validé
        $idCampagne = intval($request -> request -> get('form')['idCampagne']);
        }

        // Récupère la campagne actuelle pour les contraintes sur les notes
        $campagneActuelle = $campagneRepository -> find($idCampagne);
        $noteMaxAutobiographie = $campagneActuelle -> getNoteMaxAutobiographie();
        $noteMaxAppreciationDossier = $campagneActuelle -> getNoteMaxAppreciationDossier();

        // Valeurs par défaut du form
        $candidatureEleve = $candidatureRepository -> dossierEleve($idEleve, $idCampagne);
        $defaultData = ['idEleve' => $idEleve,
        'idCampagne' => $idCampagne,
        'noteAutobiographie' => $candidatureEleve -> getNoteAutobiographie(),
        'noteAppreciationDossier' => $candidatureEleve -> getNoteAppreciationDossier(),
        'commentaireDossier' => $candidatureEleve -> getCommentaireDossier(),
        'estTraite' => $candidatureEleve -> getEstTraite()];

        // Champs à remplir
        $form = $this->createFormBuilder($defaultData)
        -> setAction($this->generateUrl('evaluerCandidat'))
        -> add('idEleve', HiddenType::class)
        -> add('idCampagne', HiddenType::class)
        -> add('noteAutobiographie', NumberType::class, ['constraints' => [new LessThanOrEqual($noteMaxAutobiographie), new PositiveOrZero()],
                                                'label' => 'Note de la notice autobiographique (sur '.$noteMaxAutobiographie.')'])
        -> add('noteAppreciationDossier', NumberType::class, ['constraints' => [new LessThanOrEqual($noteMaxAppreciationDossier), new PositiveOrZero()],
                                                    'label' => "Note d'appréciation du dossier (sur ".$noteMaxAppreciationDossier.')'])
        -> add('commentaireDossier', TextareaType::class, ['required' => false, 'label' => 'Commentaire sur le dossier'])
        -> add('estTraite', CheckboxType::class, ['required' => false, 'label' => 'Cocher pour indiquer que le dossier est traité'])
        -> add('Valider',SubmitType::class)
        -> getForm();

        // Gère la validation du form
        $form -> handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        // Met à jour la candidature avec les notes
        $data = $form->getData();
        $candidatureEleve -> setNoteAutobiographie($data['noteAutobiographie']);
        $candidatureEleve -> setNoteAppreciationDossier($data['noteAppreciationDossier']);
        $candidatureEleve -> setCommentaireDossier($data['commentaireDossier']);
        $candidatureEleve -> setEstTraite($data['estTraite']);

        // Sauvegarde la candidature
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($candidatureEleve);
        $entityManager->flush();

        return $this->redirectToRoute('dossiersCandidats');
        }

        // Génère le form pour l'affichage
        return $this->render('prof/evaluation_candidat.html.twig', [
        'formEvaluationCandidat' => $form->createView(),
        'idEleve' => $idEleve
        ]); 
   }

}