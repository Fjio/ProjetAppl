<?php

namespace App\Controller;

use App\Entity\AnneeScolaire;
use App\Entity\Personne;
use App\Entity\Section;
use App\Form\AnneeScolaireType;
use App\Form\CandidatureSectionType;
use App\Form\EleveType;
use App\Form\NotesMatiereType;
use App\Repository\ContrainteSectionRepository;
use App\Repository\EleveRepository;
use App\Repository\MatiereRepository;
use App\Repository\PersonneRepository;
use App\Repository\AnneeScolaireRepository;
use App\Repository\CampagneRepository;
use App\Repository\CandidatureRepository;
use App\Repository\NotesMatiereRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class EtudiantDossierController
 * @package App\Controller
 * @Route("/etudiant/dossier")
 */
class EtudiantDossierController extends AbstractController
{
    /**
     * @Route("/{id}", name="etudiant_dossier",
     *     requirements={"id"="\d+"})
     * l'id est constitué d'au moins un chiffre
     * @param PersonneRepository $personneRepository
     * @param $id
     * @return Response
     */
    public function index(PersonneRepository $personneRepository, $id): Response
    {
        $dossierAdministratifEtudiant=$personneRepository->dossierAdministratifEtudiant($id);

        return $this->render('etudiant_dossier/index.html.twig', [
            'controller_name' => 'EtudiantDossierController',
            'etudiant' => $dossierAdministratifEtudiant
        ]);

    }


    /**
     * @Route("/administratif", name="etudiant_dossier_administratif")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function formulaireAdministratif(Request $request,
                                            EleveRepository $eleveRepository)
    {
        $user=$this->get('security.token_storage')->getToken()->getUser();
        $idPersonneUser=$user->getIdPersonne();

        $idEleve=$eleveRepository->findOneBy(['idPersonne'=>$idPersonneUser]);

        // Récupération d'une personne déjà existante, d'id $id.
        $eleve = $this->getDoctrine()
            ->getManager()
            ->getRepository('App:Eleve')
            ->find($idEleve);

        $form2 = $this->createForm(EleveType::class, $eleve)
            ->add('Enregistrer',SubmitType::class);

        // Si la requête est en POST
        if ($request->isMethod('POST')) {
            // On fait le lien Requête <-> Formulaire
            // À partir de maintenant, la variable $eleve contient les valeurs entrées dans le formulaire par le visiteur
            $form2->handleRequest($request);

            // On vérifie que les valeurs entrées sont correctes
            if ($form2->isValid()) {
                // On enregistre notre objet $eleve dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($eleve);
                $em->flush();


                // On redirige vers la page de visualisation
                return $this->redirectToRoute('etudiant_dossier_administratif', array('id' => $eleve->getIdPersonne()));
            }
        }

        // À ce stade, le formulaire n'est pas valide car :
        // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau
        return $this->render('etudiant_dossier/index.html.twig', array(
            'form' => $form2->createView(),
        ));
    }


    /**
     * @Route("/scolaire/parcours/{annee}", name="etudiant_dossier_scolaire_parcours")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */

    public function formulaireScolaireParcours(Request $request,
                                               AnneeScolaireRepository $anneeScolaireRepository,
                                               CampagneRepository $campagneRepository,
                                               CandidatureRepository $candidatureRepository,
                                                EleveRepository $eleveRepository,
                                               $annee)
    {

        $user=$this->get('security.token_storage')->getToken()->getUser();
        $idPersonneUser=$user->getIdPersonne();

        $idEleve=$eleveRepository->findOneBy(['idPersonne'=>$idPersonneUser]);

        $idCampagne = $campagneRepository->getIdCampagneActuelle();
        $idCampagneQuiEstEnFaitUneCandidature =
            $candidatureRepository
                ->findOneBy(['idCampagne' => $idCampagne,
                                    'idEleve' => $idEleve]);

        //ordre décroissant des années
        $anneesScolairesTab = $anneeScolaireRepository->anneesScolairesEleve($idEleve,$idCampagne);

        //si l'année existe déjà
        if (sizeof($anneesScolairesTab) >= $annee+1) {
            $anneeScolaire=$anneesScolairesTab[$annee];
        } else {

            //pré-remplissage
            if (sizeof($anneesScolairesTab) >= 1 and $annee!=3) {
                $anneeSuivante=end($anneesScolairesTab);

                //si année de lycée (supposé)
                if ($annee!=3) {
                    $anneeScolaire = clone($anneeSuivante);

                    $anneeScolaire
                        ->setAnnee($anneeScolaire->getAnnee()-1)
                        ->setClasse('');

                } else {
                    $anneeScolaire = new AnneeScolaire();
                    $anneeScolaire
                        ->setAnnee($anneeScolaire->getAnnee()-1);
                }

            } else {
                $anneeScolaire = new AnneeScolaire();
                $anneeScolaire->setIdCampagne($idCampagneQuiEstEnFaitUneCandidature);
            }

            //ajout au tableau
            $anneesScolairesTab[] = $anneeScolaire;
        }



        $form = $this->createForm(AnneeScolaireType::class, $anneesScolairesTab[$annee])
            ->add('Enregistrer',SubmitType::class);

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($anneeScolaire);
                $em->flush();

                if ($annee<3) {
                    $annee += 1;
                    return $this->redirectToRoute('etudiant_dossier_scolaire_parcours', array('annee' => $annee));
                } else {
                    return $this->redirectToRoute('etudiant_dossier_scolaire_notes', array('annee' => $annee));
                }

            }
        }

        return $this->render('etudiant_dossier/parcoursScolaire.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("/scolaire/notes", name="etudiant_dossier_scolaire_notes")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function formulaireScolaireNotes(Request $request,
                                            CandidatureRepository $candidatureRepository,
                                            CampagneRepository $campagneRepository,
                                            MatiereRepository $matiereRepository,
                                            NotesMatiereRepository $notesMatiereRepository,
                                            EleveRepository $eleveRepository)
    {

        $user=$this->get('security.token_storage')->getToken()->getUser();
        $idPersonneUser=$user->getIdPersonne();

        $idEleve=$eleveRepository->findOneBy(['idPersonne'=>$idPersonneUser]);

        $idCampagne = $campagneRepository->getIdCampagneActuelle();

        $candidature =
            $candidatureRepository
                ->findOneBy(['idCampagne' => $idCampagne,
                            'idEleve' => $idEleve]);
        $idCampagneQuiEstEnFaitUneCandidature = $candidature;

        $choixSection=$candidature->getNomSection();

        $idCampagne = $campagneRepository->getIdCampagneActuelle();

        $listeMatieres=$matiereRepository->findAll();

        $listeForm=[];

        $listeFormRenderedEtMatiere=[];
        $i=0;

        $notesMatiereTab=[];

        foreach ($listeMatieres as $matiere) {
            $i++;
            $notesMatiere=$notesMatiereRepository->findOneBy(['idCampagne'=>$idCampagneQuiEstEnFaitUneCandidature,
                                                                'nomMatiere'=>$matiere->getNomMatiere()]);

            $notesMatiereTab[]=$notesMatiere;
            $form = $this->createForm(NotesMatiereType::class, $notesMatiere);

            $listeForm[]=$form;
            $key='form'.$i;
            $listeFormRenderedEtMatiere[$key]= [$form->createView(),$matiere];
         }
            end($listeForm) ->add('Enregistrer',SubmitType::class);
            $listeFormRenderedEtMatiere[$key][0]=end($listeForm)->createView();

        if ($request->isMethod('POST')) {

            for ($i=0;$i<sizeof($listeMatieres);$i++) {

                $listeForm[$i]->handleRequest($request);

                if($listeForm[$i]->isSubmitted()) {
                    if ($listeForm[$i]->isValid()) {

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($notesMatiereTab[$i]);
                        $em->flush();

                        return $this->redirectToRoute('etudiant_dossier_scolaire_notes');
                    }
                }
            }
        }

        return $this->render('etudiant_dossier/notes.html.twig', [
            'listeform'=>$listeFormRenderedEtMatiere,
        ]
            );
    }


    /**
     * @Route("/choixsection", name="etudiant_dossier_choixsection")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */


    public function formulaireChoixSection(Request $request,
                                                   CandidatureRepository $candidatureRepository,
                                                   CampagneRepository $campagneRepository,
                                                    ContrainteSectionRepository $contrainteSectionRepository,
                                                     EleveRepository $eleveRepository)
    {
        $user=$this->get('security.token_storage')->getToken()->getUser();
        $idPersonneUser=$user->getIdPersonne();

        $idEleve=$eleveRepository->findOneBy(['idPersonne'=>$idPersonneUser]);

        $idCampagne = $campagneRepository->getIdCampagneActuelle();

        $candidature =
            $candidatureRepository
                ->findOneBy(['idCampagne' => $idCampagne,
                            'idEleve' => $idEleve]);

        $choixSection=$candidature->getNomSection();

        $sections=$this->getDoctrine()->getManager()->getRepository(Section::class)->findBy([],['nomSection'=>'ASC']);

        $messageContraintesTab =
            $contrainteSectionRepository
                ->findAll();



        $form = $this->createForm(CandidatureSectionType::class, $candidature,array('sectionsPossibles'=>$sections))
            ->add('Enregistrer',SubmitType::class) ;


        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($choixSection);
                $em->flush();

                return $this->redirectToRoute('etudiant_dossier_choixsection');
            }
        }


        return $this->render('etudiant_dossier/section.html.twig', array(
            'form' => $form->createView(),
            'contrainteSectionTab'=>$messageContraintesTab,
        ));
    }

    /**
     * @Route("/validation", name="etudiant_dossier_validation")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */


    public function formulaireValidation(Request $request,
                                                   CandidatureRepository $candidatureRepository,
                                                   CampagneRepository $campagneRepository,
                                                   ContrainteSectionRepository $contrainteSectionRepository,
                                                     EleveRepository $eleveRepository)
    {

        $user=$this->get('security.token_storage')->getToken()->getUser();
        $idPersonneUser=$user->getIdPersonne();

        $idEleve=$eleveRepository->findOneBy(['idPersonne'=>$idPersonneUser]);

        $idCampagne = $campagneRepository->getIdCampagneActuelle();

        $candidature =
            $candidatureRepository
                ->findOneBy(['idCampagne' => $idCampagne,
                    'idEleve' => $idEleve]);

        $choixSection=$candidature->getNomSection();

        $etatDossier='incomplet';
        $numeroDossier="";

        if (!is_null($choixSection)) {
            $nomSection=$choixSection->getNomSection();
            $etatDossier='complet';

            $nombreCandidatureFiliere=sizeof($candidatureRepository->findBy(['nomSection'=>$choixSection]));
            $nombreCandidatureFiliere=strval($nombreCandidatureFiliere);

            for ($i=strlen($nombreCandidatureFiliere);$i<5;$i++){
                $nombreCandidatureFiliere="0".$nombreCandidatureFiliere;
            }

            switch ($nomSection) {
                case "Son":
                    $numeroDossier=$numeroDossier."SON";
                    break;
                case "Image":
                    $numeroDossier=$numeroDossier."IMA";
                    break;
                case "Littéraire":
                    $numeroDossier=$numeroDossier."LIT";
                    break;
                default: //cas d'une erreur, n'est pas censé arriver
                    $numeroDossier=$numeroDossier."ERR";
                    break;
            }
            $numeroDossier=$numeroDossier.$nombreCandidatureFiliere;
        }


        $form = $this->createForm(FormType::class, [],[])
            ->add('Soumettre',SubmitType::class) ;


        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $candidature->setNumeroDossier($numeroDossier);


                $em = $this->getDoctrine()->getManager();
                $em->persist($candidature);
                $em->flush();

                return $this->redirectToRoute('etudiant_dossier_validation');
            }
        }


        return $this->render('etudiant_dossier/validation.html.twig', array(
            'form' => $form->createView(),
            'etatDossier'=>$etatDossier,
        ));
    }

}
