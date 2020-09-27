<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Candidature
 *
 * @ORM\Table(name="candidature", indexes={@ORM\Index(name="IDX_E33BD3B8340B183", columns={"id_campagne"}), @ORM\Index(name="IDX_E33BD3B8D8FC7127", columns={"nom_section"}), @ORM\Index(name="IDX_E33BD3B88A968B91", columns={"id_prof_assigne"}), @ORM\Index(name="IDX_E33BD3B822444C7", columns={"id_eleve"})})
 * @ORM\Entity(repositoryClass="App\Repository\CandidatureRepository")
 */
class Candidature
{
    /**
     * @var float|null
     *
     * @ORM\Column(name="note_moyenne_generale", type="float", precision=10, scale=0, nullable=true, options={"comment"="Moyenne générale"})
     */
    private $noteMoyenneGenerale;

    /**
     * @var float|null
     *
     * @ORM\Column(name="note_autobiographie", type="float", precision=10, scale=0, nullable=true, options={"comment"="Note donnée à la notice autobiographique"})
     */
    private $noteAutobiographie;

    /**
     * @var float|null
     *
     * @ORM\Column(name="note_appreciation_dossier", type="float", precision=10, scale=0, nullable=true, options={"comment"="Appréciation du dossier"})
     */
    private $noteAppreciationDossier;

    /**
     * @var float|null
     *
     * @ORM\Column(name="note_admissibilite", type="float", precision=10, scale=0, nullable=true, options={"comment"="Calculée à partir des notes r, n et appreciation.\
     * Sert à classer les dossiers pour sélectionner les candidats admissibles"})
     */
    private $noteAdmissibilite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="commentaire_dossier", type="string", nullable=true)
     */
    private $commentaireDossier;

    /**
     * @var int|null
     *
     * @ORM\Column(name="classement_admissibilite", type="integer", nullable=true)
     */
    private $classementAdmissibilite;

    /**
     * @var int
     *
     * @ORM\Column(name="statut_admission", type="integer", nullable=false, options={"comment"="0 : défaut\
     * 1 : admis sur liste principale\
     * 2 : liste d'attente (position disponible dans position_liste_attente)"})
     */
    private $statutAdmission;

    /**
     * @var int|null
     *
     * @ORM\Column(name="position_liste_attente", type="integer", nullable=true)
     */
    private $positionListeAttente;

    /**
     * @var string|null
     *
     * @ORM\Column(name="numero_dossier", type="string", nullable=true, options={"comment"="Numéro de dossier commencant par une lettre indiquant la filière puis un numéro. Il ne sert pas à identifier les candidatures dans la base."})
     */
    private $numeroDossier;

    /**
     * @var string|null
     *
     * @ORM\Column(name="demi_journee_convocation", type="string", nullable=true, options={"comment"="A, B, ou C suivant la demi-journée à laquelle le candidat est convoqué pour l'oral d'admission"})
     */
    private $demiJourneeConvocation;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="est_traite", type="boolean", nullable=true)
     */
    private $estTraite;

    /**
     * @var \Campagne
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Campagne")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_campagne", referencedColumnName="id_campagne")
     * })
     */
    private $idCampagne;

    /**
     * @var \Section
     *
     * @ORM\ManyToOne(targetEntity="Section")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="nom_section", referencedColumnName="nom_section")
     * })
     */
    private $nomSection;

    /**
     * @var \Personne
     *
     * @ORM\ManyToOne(targetEntity="Personne")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_prof_assigne", referencedColumnName="id_personne")
     * })
     */
    private $idProfAssigne;

    /**
     * @var \Eleve
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Eleve")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_eleve", referencedColumnName="id_eleve")
     * })
     */
    private $idEleve;

    public function getNoteMoyenneGenerale(): ?float
    {
        return $this->noteMoyenneGenerale;
    }

    public function setNoteMoyenneGenerale(?float $noteMoyenneGenerale): self
    {
        $this->noteMoyenneGenerale = $noteMoyenneGenerale;

        return $this;
    }

    public function getNoteAutobiographie(): ?float
    {
        return $this->noteAutobiographie;
    }

    public function setNoteAutobiographie(?float $noteAutobiographie): self
    {
        $this->noteAutobiographie = $noteAutobiographie;

        return $this;
    }

    public function getNoteAppreciationDossier(): ?float
    {
        return $this->noteAppreciationDossier;
    }

    public function setNoteAppreciationDossier(?float $noteAppreciationDossier): self
    {
        $this->noteAppreciationDossier = $noteAppreciationDossier;

        return $this;
    }

    public function getNoteAdmissibilite(): ?float
    {
        return $this->noteAdmissibilite;
    }

    public function setNoteAdmissibilite(?float $noteAdmissibilite): self
    {
        $this->noteAdmissibilite = $noteAdmissibilite;

        return $this;
    }

    public function getCommentaireDossier(): ?string
    {
        return $this->commentaireDossier;
    }

    public function setCommentaireDossier(?string $commentaireDossier): self
    {
        $this->commentaireDossier = $commentaireDossier;

        return $this;
    }

    public function getClassementAdmissibilite(): ?int
    {
        return $this->classementAdmissibilite;
    }

    public function setClassementAdmissibilite(?int $classementAdmissibilite): self
    {
        $this->classementAdmissibilite = $classementAdmissibilite;

        return $this;
    }

    public function getStatutAdmission(): ?int
    {
        return $this->statutAdmission;
    }

    public function setStatutAdmission(int $statutAdmission): self
    {
        $this->statutAdmission = $statutAdmission;

        return $this;
    }

    public function getPositionListeAttente(): ?int
    {
        return $this->positionListeAttente;
    }

    public function setPositionListeAttente(?int $positionListeAttente): self
    {
        $this->positionListeAttente = $positionListeAttente;

        return $this;
    }

    public function getNumeroDossier(): ?string
    {
        return $this->numeroDossier;
    }

    public function setNumeroDossier(?string $numeroDossier): self
    {
        $this->numeroDossier = $numeroDossier;

        return $this;
    }

    public function getDemiJourneeConvocation(): ?string
    {
        return $this->demiJourneeConvocation;
    }

    public function setDemiJourneeConvocation(?string $demiJourneeConvocation): self
    {
        $this->demiJourneeConvocation = $demiJourneeConvocation;

        return $this;
    }

    public function getEstTraite(): ?bool
    {
        return $this->estTraite;
    }

    public function setEstTraite(?bool $estTraite): self
    {
        $this->estTraite = $estTraite;

        return $this;
    }

    public function getIdCampagne(): ?Campagne
    {
        return $this->idCampagne;
    }

    public function setIdCampagne(?Campagne $idCampagne): self
    {
        $this->idCampagne = $idCampagne;

        return $this;
    }

    public function getNomSection(): ?Section
    {
        return $this->nomSection;
    }

    public function setNomSection(?Section $nomSection): self
    {
        $this->nomSection = $nomSection;

        return $this;
    }

    public function getIdProfAssigne(): ?Personne
    {
        return $this->idProfAssigne;
    }

    public function setIdProfAssigne(?Personne $idProfAssigne): self
    {
        $this->idProfAssigne = $idProfAssigne;

        return $this;
    }

    public function getIdEleve(): ?Eleve
    {
        return $this->idEleve;
    }

    public function setIdEleve(?Eleve $idEleve): self
    {
        $this->idEleve = $idEleve;

        return $this;
    }


}
