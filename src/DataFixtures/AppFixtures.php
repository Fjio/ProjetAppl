<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use \DateTime;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\AnneeScolaire;
use App\Entity\Calendrier;
use App\Entity\Campagne;
use App\Entity\Candidature;
use App\Entity\Coefficient;
use App\Entity\ContrainteSection;
use App\Entity\Eleve;
use App\Entity\Matiere;
use App\Entity\NotesMatiere;
use App\Entity\Option;
use App\Entity\Personne;
use App\Entity\PossibiliteOption;
use App\Entity\QualiteResponsableLegal;
use App\Entity\ResponsableLegal;
use App\Entity\Section;
use App\Entity\Utilisateur;


class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        

        // Qualité du responsable legal
        $qualite = new QualiteResponsableLegal();
        $qualite -> setQualite("Père");
        $manager -> persist($qualite);

        $qualite2 = new QualiteResponsableLegal();
        $qualite2 -> setQualite("Mère");
        $manager -> persist($qualite2);

        $qualite3 = new QualiteResponsableLegal();
        $qualite3 -> setQualite("Tuteur");
        $manager -> persist($qualite3);

        // Rôle
        $eleveRole = "ROLE_ELEVE";
        $professeurRole = "ROLE_PROFESSEUR";
        $adminRole = "ROLE_ADMIN";

        //Personne
        $responsable = new Personne();
        $responsable -> setMail("responsable@responsable.fr");
        $responsable -> setNom("Responsable");
        $responsable -> setPrenom("Responsable");
        $responsable -> setTel("06 00 00 00 00");
        $responsable -> setNumeroRue(1);
        $responsable -> setNomRue("rue de la Noé");
        $responsable -> setCodePostal(44000);
        $responsable -> setLocalite("Nantes");
        $responsable -> setPays("France");
        $manager -> persist($responsable);

        $elevePersonne = new Personne();
        $elevePersonne -> setMail("eleve1@eleve.fr");
        $elevePersonne -> setNom("Eleve1_nom");
        $elevePersonne -> setPrenom("Eleve1_prenom");
        $elevePersonne -> setTel("06 00 00 00 01");
        $elevePersonne -> setNumeroRue(1);
        $elevePersonne -> setNomRue("rue de la Noé");
        $elevePersonne -> setCodePostal(44000);
        $elevePersonne -> setLocalite("Nantes");
        $elevePersonne -> setPays("France");
        $manager -> persist($elevePersonne);

        $elevePersonne2 = new Personne();
        $elevePersonne2 -> setMail("eleve1@eleve.fr");
        $elevePersonne2 -> setNom("Eleve2_nom");
        $elevePersonne2 -> setPrenom("Eleve2_prenom");
        $elevePersonne2 -> setTel("06 00 00 00 01");
        $elevePersonne2 -> setNumeroRue(1);
        $elevePersonne2 -> setNomRue("rue de la Noé");
        $elevePersonne2 -> setCodePostal(44000);
        $elevePersonne2 -> setLocalite("Nantes");
        $elevePersonne2 -> setPays("France");
        $manager -> persist($elevePersonne2);

        $professeurPersonne = new Personne();
        $professeurPersonne -> setMail("prof@prof.fr");
        $professeurPersonne -> setNom("NomProf1");
        $professeurPersonne -> setPrenom("PrénomProf1");
        $manager -> persist($professeurPersonne);

        $professeurPersonne2 = new Personne();
        $professeurPersonne2 -> setMail("prof2@prof2.fr");
        $professeurPersonne2 -> setNom("NomProf2");
        $professeurPersonne2 -> setPrenom("PrénomProf2");
        $manager -> persist($professeurPersonne2);

        $adminPersonne = new Personne();
        $adminPersonne -> setMail("admin@admin.fr");
        $adminPersonne -> setNom("NomAdmin");
        $adminPersonne -> setPrenom("PrénomAdmin");
        $manager -> persist($adminPersonne);

        //Utilisateur
        $eleveUser = new Utilisateur();
        $eleveUser -> setRoles($eleveRole);
        $eleveUser -> setIdPersonne($elevePersonne);
        $eleveUser -> setPassword($this->passwordEncoder->encodePassword($eleveUser,'eleve'));
        $eleveUser -> setUsername($elevePersonne -> getMail());
        $eleveUser -> setCreationDate(new \Datetime("2020-10-04"));
        $eleveUser -> setToken("1");
        $eleveUser -> setValidatedUser(TRUE);
        $manager -> persist($eleveUser);
        $manager -> flush();
/*
        $professeurUser = new Utilisateur();
        $professeurUser -> setRoles($professeurRole);
        $professeurUser -> setIdPersonne($professeurPersonne);
        $professeurUser -> setPassword($this->passwordEncoder->encodePassword($professeurUser,'prof'));
        $professeurUser -> setUsername($professeurPersonne -> getMail());
        $manager -> persist($professeurUser);

        $professeurUser2 = new Utilisateur();
        $professeurUser2 -> setRoles($professeurRole);
        $professeurUser2 -> setIdPersonne($professeurPersonne2);
        $professeurUser2 -> setPassword($this->passwordEncoder->encodePassword($professeurUser2,'prof'));
        $professeurUser2 -> setUsername($professeurPersonne2 -> getMail());
        $manager -> persist($professeurUser2);

        $adminUser = new Utilisateur();
        $adminUser -> setRoles($adminRole);
        $adminUser -> setIdPersonne($adminPersonne);
        $adminUser -> setPassword($this->passwordEncoder->encodePassword($adminUser,'admin'));
        $adminUser -> setUsername($adminPersonne -> getMail());
        $manager -> persist($adminUser);

        //Responsable Legal
        $responsableLegal = new ResponsableLegal();
        $responsableLegal -> setIdResponsable($responsable);
        $responsableLegal -> setQualite($qualite);
        $manager -> persist($responsableLegal);

        //Eleve
        $eleveEleve = new Eleve();
        $eleveEleve -> setIdResponsable($responsableLegal);
        $eleveEleve -> setDateNaissance(new DateTime());
        $eleveEleve -> setIdPersonne($elevePersonne);
        $manager -> persist($eleveEleve);

        $eleveEleve2 = new Eleve();
        $eleveEleve2 -> setIdResponsable($responsableLegal);
        $eleveEleve2 -> setDateNaissance(new DateTime());
        $eleveEleve2 -> setIdPersonne($elevePersonne2);
        $manager -> persist($eleveEleve2);

        // Campagne
        $campagne = new Campagne();
        $campagne -> setAnnee(2020);
        $campagne -> setCoefNoteMoyenneGenerale(5.0);
        $campagne -> setCoefNoteAppreciationDossier(1.0);
        $campagne -> setCoefNoteAutobiographie(4.0);
        $campagne -> setNoteMaxMoyenneGenerale(20);
        $campagne -> setNoteMaxAppreciationDossier(5);
        $campagne -> setNoteMaxAutobiographie(20);
        $manager -> persist($campagne);

        //Calendrier
        $calendrier = new Calendrier();
        $calendrier->setIdCampagne($campagne);
        $calendrier->setDate(new DateTime());
        $calendrier->setCodeJalon("ouverture_candidature");
        $calendrier->setDescJalon("Ouverture des candidatures");
        $manager->persist($calendrier);

        $calendrier2 = new Calendrier();
        $calendrier2 ->setIdCampagne($campagne);
        $calendrier2 ->setDate(new DateTime());
        $calendrier2 ->setCodeJalon("fermeture_candidature");
        $calendrier2->setDescJalon("Fermeture des candidatures");
        $manager->persist($calendrier2);

        $calendrier3 = new Calendrier();
        $calendrier3->setIdCampagne($campagne);
        $calendrier3->setDate(new DateTime());
        $calendrier3->setCodeJalon("resultat_admissibilite");
        $calendrier3->setDescJalon("Resultat des admissibles");
        $manager->persist($calendrier3);

        $calendrier4 = new Calendrier();
        $calendrier4->setIdCampagne($campagne);
        $calendrier4->setDate(new DateTime());
        $calendrier4->setCodeJalon("resultat_admission");
        $calendrier4->setDescJalon("Resultat des admis");
        $manager->persist($calendrier4);

        // Matière
        $matiere = new Matiere();
        $matiere -> setNomMatiere("Français de première");
        $matiere -> setNature("matiere");
        $manager -> persist($matiere);

        $matiere2 = new Matiere();
        $matiere2 -> setNomMatiere("Français écrit");
        $matiere2 -> setNature("matiere");
        $manager -> persist($matiere2);

        $matiere3 = new Matiere();
        $matiere3-> setNomMatiere("Français oral");
        $matiere3 -> setNature("matiere");
        $manager -> persist($matiere3);

        $matiere4 = new Matiere();
        $matiere4 -> setNomMatiere("Philosophie");
        $matiere4 -> setNature("matiere");
        $manager -> persist($matiere4);

        $matiere5 = new Matiere();
        $matiere5 -> setNomMatiere("Histoire Géographie");
        $matiere5 -> setNature("matiere");
        $manager -> persist($matiere5);

        $matiere6 = new Matiere();
        $matiere6 -> setNomMatiere("Anglais");
        $matiere6 -> setNature("matiere");
        $manager -> persist($matiere6);

        $matiere7 = new Matiere();
        $matiere7 -> setNomMatiere("Spécialité abandonnée en première");
        $matiere7 -> setNature("specialite");
        $manager -> persist($matiere7);

        $matiere8 = new Matiere();
        $matiere8 -> setNomMatiere("Spécialité 1");
        $matiere8 -> setNature("specialite");
        $manager -> persist($matiere8);

        $matiere9 = new Matiere();
        $matiere9 -> setNomMatiere("Spécialité 2");
        $matiere9 -> setNature("specialite");
        $manager -> persist($matiere9);

        $matiere10 = new Matiere();
        $matiere10 -> setNomMatiere("Option");
        $matiere10 -> setNature("option");
        $manager -> persist($matiere10);

        //Option 

        $specialite = new Option();
        $specialite->setAcronymeOption("ART");
        $specialite->setNomEntier("");
        $specialite->setEstSpecialite(true);
        $specialite->setEstOption(false);
        $manager->persist($specialite);

        $specialite2 = new Option();
        $specialite2->setAcronymeOption("LLCE");
        $specialite2->setNomEntier("");
        $specialite2->setEstSpecialite(true);
        $specialite2->setEstOption(false);
        $manager->persist($specialite2);

        $specialite3 = new Option();
        $specialite3->setAcronymeOption("LLCA");
        $specialite3->setNomEntier("");
        $specialite3->setEstSpecialite(true);
        $specialite3->setEstOption(false);
        $manager->persist($specialite3);

        $specialite4 = new Option();
        $specialite4->setAcronymeOption("HUM");
        $specialite4->setNomEntier("");
        $specialite4->setEstSpecialite(true);
        $specialite4->setEstOption(false);
        $manager->persist($specialite4);

        $specialite5 = new Option();
        $specialite5->setAcronymeOption("GEOPO");
        $specialite5->setNomEntier("");
        $specialite5->setEstSpecialite(true);
        $specialite5->setEstOption(false);
        $manager->persist($specialite5);
        
        $option = new Option();
        $option->setAcronymeOption("ART");
        $option->setNomEntier("");
        $option->setEstSpecialite(false);
        $option->setEstOption(true);
        $manager->persist($option);

        $option2 = new Option();
        $option2->setAcronymeOption("EPS");
        $option2->setNomEntier("");
        $option2->setEstSpecialite(false);
        $option2->setEstOption(true);
        $manager->persist($option2);

        $option3 = new Option();
        $option3->setAcronymeOption("LCA");
        $option3->setNomEntier("");
        $option3->setEstSpecialite(false);
        $option3->setEstOption(true);
        $manager->persist($option3);

        $option4 = new Option();
        $option4->setAcronymeOption("EXP");
        $option4->setNomEntier("Mathématiques expertes");
        $option4->setEstSpecialite(false);
        $option4->setEstOption(true);
        $manager->persist($option4);

        $option5 = new Option();
        $option5->setAcronymeOption("COMP");
        $option5->setNomEntier("Mathématiques complémentaires");
        $option5->setEstSpecialite(false);
        $option5->setEstOption(true);
        $manager->persist($option5);

        $option6 = new Option();
        $option6->setAcronymeOption("DROIT");
        $option6->setNomEntier("");
        $option6->setEstSpecialite(false);
        $option6->setEstOption(true);
        $manager->persist($option6);

        $option7 = new Option();
        $option7->setAcronymeOption("LVC");
        $option7->setNomEntier("");
        $option7->setEstSpecialite(false);
        $option7->setEstOption(true);
        $manager->persist($option7);

        //Section
        $section = new Section();
        $section -> setNomSection('Son');
        $manager -> persist($section);

        $section2 = new Section();
        $section2 -> setNomSection('Image');
        $manager -> persist($section2);

        $section3 = new Section();
        $section3 -> setNomSection('Littéraire');
        $manager -> persist($section3);

        //Possibilite Option

        $pOption = new PossibiliteOption();
        $pOption->setIdCampagne($campagne);
        $pOption->setNomSection($section);
        $pOption->setNomMatiere($matiere8);
        $pOption->setIdOption($specialite);
        $manager->persist($pOption);

        $pOption2 = new PossibiliteOption();
        $pOption2->setIdCampagne($campagne);
        $pOption2->setNomSection($section);
        $pOption2->setNomMatiere($matiere8);
        $pOption2->setIdOption($specialite2);
        $manager->persist($pOption2);

        $pOption3 = new PossibiliteOption();
        $pOption3->setIdCampagne($campagne);
        $pOption3->setNomSection($section);
        $pOption3->setNomMatiere($matiere8);
        $pOption3->setIdOption($specialite3);
        $manager->persist($pOption3);

        $pOption4 = new PossibiliteOption();
        $pOption4->setIdCampagne($campagne);
        $pOption4->setNomSection($section);
        $pOption4->setNomMatiere($matiere8);
        $pOption4->setIdOption($specialite4);
        $manager->persist($pOption4);

        $pOption5 = new PossibiliteOption();
        $pOption5->setIdCampagne($campagne);
        $pOption5->setNomSection($section);
        $pOption5->setNomMatiere($matiere8);
        $pOption5->setIdOption($specialite5);
        $manager->persist($pOption5);
                
        //Coefficient 

        $coefficient = new Coefficient();
        $coefficient->setIdCampagne($campagne);
        $coefficient->setNomSection($section);
        $coefficient->setValeur(2.0);
        $coefficient->setNomMatiere($matiere);
        $manager->persist($coefficient);

        $coefficient2 = new Coefficient();
        $coefficient2->setIdCampagne($campagne);
        $coefficient2->setNomSection($section);
        $coefficient2->setValeur(0.5);
        $coefficient2->setNomMatiere($matiere2);
        $manager->persist($coefficient2);

        $coefficient3 = new Coefficient();
        $coefficient3->setIdCampagne($campagne);
        $coefficient3->setNomSection($section);
        $coefficient3->setValeur(0.5);
        $coefficient3->setNomMatiere($matiere3);
        $manager->persist($coefficient3);

        $coefficient4 = new Coefficient();
        $coefficient4->setIdCampagne($campagne);
        $coefficient4->setNomSection($section);
        $coefficient4->setValeur(2.0);
        $coefficient4->setNomMatiere($matiere4);
        $manager->persist($coefficient4);

        $coefficient5 = new Coefficient();
        $coefficient5->setIdCampagne($campagne);
        $coefficient5->setNomSection($section);
        $coefficient5->setValeur(2.0);
        $coefficient5->setNomMatiere($matiere5);
        $manager->persist($coefficient5);

        $coefficient6 = new Coefficient();
        $coefficient6->setIdCampagne($campagne);
        $coefficient6->setNomSection($section);
        $coefficient6->setValeur(2.0);
        $coefficient6->setNomMatiere($matiere6);
        $manager->persist($coefficient6);

        $coefficient7 = new Coefficient();
        $coefficient7->setIdCampagne($campagne);
        $coefficient7->setNomSection($section);
        $coefficient7->setValeur(5.0);
        $coefficient7->setNomMatiere($matiere7);
        $manager->persist($coefficient7);

        $coefficient8 = new Coefficient();
        $coefficient8->setIdCampagne($campagne);
        $coefficient8->setNomSection($section);
        $coefficient8->setValeur(5.0);
        $coefficient8->setNomMatiere($matiere8);
        $manager->persist($coefficient8);

        $coefficient9 = new Coefficient();
        $coefficient9->setIdCampagne($campagne);
        $coefficient9->setNomSection($section);
        $coefficient9->setValeur(5.0);
        $coefficient9->setNomMatiere($matiere9);
        $manager->persist($coefficient9);

        $coefficient10 = new Coefficient();
        $coefficient10->setIdCampagne($campagne);
        $coefficient10->setNomSection($section);
        $coefficient10->setValeur(2.0);
        $coefficient10->setNomMatiere($matiere10);
        $manager->persist($coefficient10);

        //Contrainte Section

        $cSection = new ContrainteSection();
        $cSection->setNomSection($section);
        $cSection->setIdCampagne($campagne);
        $cSection->setMessageContrainte("L'étudiant doit avoir suivi les spécialités Maths et Physique en Terminale");
        $manager->persist($cSection);

        $cSection2 = new ContrainteSection();
        $cSection2->setNomSection($section2);
        $cSection2->setIdCampagne($campagne);
        $cSection2->setMessageContrainte("Pas de contrainte");
        $manager->persist($cSection2);

        $cSection3 = new ContrainteSection();
        $cSection3->setNomSection($section3);
        $cSection3->setIdCampagne($campagne);
        $cSection3->setMessageContrainte("L'étudiant doit avoir fait (spé maths) ou (phys + spé différente de maths + maths complémentaires)");
        $manager->persist($cSection3);

        //Candidature
        $candidature = new Candidature();
        $candidature -> setIdEleve($eleveEleve);
        $candidature -> setIdCampagne($campagne);
        $candidature -> setNoteAutobiographie(17.0);
        $candidature -> setNoteAppreciationDossier(4.3);
        $candidature -> setNoteMoyenneGenerale(16.3);
        $candidature -> setClassementAdmissibilite(1);
        $candidature -> setStatutAdmission(0);
        $candidature -> setNomSection($section);
        $candidature -> setNumeroDossier("SON001");
        $candidature -> setEstTraite(true);
        $candidature -> setIdProfAssigne($professeurPersonne);
        $manager -> persist($candidature);

        $candidature2 = new Candidature();
        $candidature2 -> setIdEleve($eleveEleve2);
        $candidature2 -> setIdCampagne($campagne);
        $candidature2 -> setNoteAutobiographie(13.0);
        $candidature2 -> setNoteAppreciationDossier(3.3);
        $candidature2 -> setNoteMoyenneGenerale(15.3);
        $candidature2 -> setClassementAdmissibilite(2);
        $candidature2 -> setStatutAdmission(0);
        $candidature2 -> setNomSection($section);
        $candidature2 -> setNumeroDossier("SON002");
        $candidature2 -> setEstTraite(false);
        //$candidature2 -> setIdProfAssigne($professeurPersonne);
        $manager -> persist($candidature2);

        //Annee Scolaire
        $annee = new AnneeScolaire();
        $annee -> setIdCampagne($candidature);
        $annee -> setPays('France');
        $annee -> setCodePostal('44000');
        $annee -> setNomRue('rue de la Noé');
        $annee -> setNumeroRue('1');
        $annee -> setAnnee('2020');
        $annee -> setClasse('terminale');
        $annee -> setEtablissement('Lycée Guist hau');
        $annee -> setVille('Nantes');
        $manager -> persist($annee);

        //Notes Matiere

        $nMatiere = new NotesMatiere();
        $nMatiere->setIdCampagne($candidature);
        $nMatiere->setNoteMinClasse(3.0);
        $nMatiere->setNoteMaxClasse(17.0);
        $nMatiere->setNoteMoyClasse(10.0);
        $nMatiere->setNoteEleve(13.0);
        $nMatiere->setNomMatiere($matiere);
        $manager->persist($nMatiere);

        $nMatiere2 = new NotesMatiere();
        $nMatiere2->setIdCampagne($candidature);
        $nMatiere2->setNoteMinClasse(3.0);
        $nMatiere2->setNoteMaxClasse(17.0);
        $nMatiere2->setNoteMoyClasse(10.0);
        $nMatiere2->setNoteEleve(13.0);
        $nMatiere2->setNomMatiere($matiere8);
        $nMatiere2->setIdOption($specialite2);
        $manager->persist($nMatiere2);

        $manager->flush(); */
    } 
}