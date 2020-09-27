<?php

namespace App\Controller;

use App\Repository\AnneeScolaireRepository;
use App\Repository\CampagneRepository;
use App\Repository\CandidatureRepository;
use App\Repository\NotesMatiereRepository;
use App\Security\LoginAuthenticator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Campagne;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\PositiveOrZero;


/**
 * Class DossierCandidatController
 * @package App\Controller
 * @Route("/prof")
 * @IsGranted("ROLE_PROFESSEUR")
 */
class DossierCandidatController extends AbstractController
{

    /**
     * @Route("/dossiersCandidats", name="dossiersCandidats")
     * @param CandidatureRepository $candidatureRepository
     * @return Response
     */
    public function dossiersCandidats(CandidatureRepository $candidatureRepository): Response {
        $idProfesseur = $this->get('security.token_storage')->getToken()->getUser()->getIdPersonne(); // Récupère l'id du professeur connecté
        $idCampagneActuelle = $this->getDoctrine()->getRepository(Campagne::class)->getIdCampagneActuelle();
        $listeDossiers = $candidatureRepository -> listeDossiersProf($idCampagneActuelle, $idProfesseur); //calcul des dossiers dans le Repository Candidature
        return $this->render('prof/dossiers_candidats.html.twig',
            ['listeDossiers' => $listeDossiers]);
    }

    /**
     * @Route("/afficheCandidat", name="afficheCandidat")
     * @param CandidatureRepository $candidatureRepository
     * @param NotesMatiereRepository $notesMatiereRepository
     * @param AnneeScolaireRepository $anneeScolaireRepository
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function afficheCandidat(CandidatureRepository $candidatureRepository, NotesMatiereRepository $notesMatiereRepository,
                                    AnneeScolaireRepository $anneeScolaireRepository, Request $request): Response {
        $idCampagneActuelle = $this->getDoctrine()->getRepository(Campagne::class)->getIdCampagneActuelle();
        $idEleve = $request->request->get('idEleve');

        $dossier = $candidatureRepository->dossierEleve($idEleve, $idCampagneActuelle); // calcul du dossier du candidat Personne dans le Repository Candidature
        $notes = $notesMatiereRepository->notesEleve($idEleve, $idCampagneActuelle);
        $anneesScolaires = $anneeScolaireRepository->anneesScolairesEleve($idEleve, $idCampagneActuelle);

        return $this -> render('prof/dossier.html.twig',
            ['dossier' => $dossier,
                'notes' => $notes, 'anneesScolaires' => $anneesScolaires,
                'idEleve' => $idEleve,
                'idCampagne' => $idCampagneActuelle]);
    }

    /**
     * Gère le formulaire d'évaluation d'un élève par un professeur.
     * @Route("/evaluerCandidat", name="evaluerCandidat")
     * @param Request $request
     * @param CampagneRepository $campagneRepository
     * @param CandidatureRepository $candidatureRepository
     * @param null $idEleve L'id de l'élève à noter. null par défaut pour pouvoir utiliser la même route pour générer le
     * form et le valider.
     * @param null $idCampagne L'id de la campagne durant laquelle l'élève est noté. null par défaut pour pouvoir
     * utiliser la même route pour générer le form et le valider.
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function evaluerCandidat(Request $request, CampagneRepository $campagneRepository, CandidatureRepository $candidatureRepository,
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
