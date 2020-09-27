<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NotesMatiere
 *
 * @ORM\Table(name="notes_matiere", indexes={@ORM\Index(name="IDX_90C21B1E659B5C82", columns={"nom_matiere"}), @ORM\Index(name="IDX_90C21B1E7CB1B55D", columns={"id_option"}), @ORM\Index(name="IDX_90C21B1E340B18322444C7", columns={"id_campagne", "id_eleve"})})
 * @ORM\Entity
 */
class NotesMatiere
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_notes_matiere", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="notes_matiere_id_notes_matiere_seq", allocationSize=1, initialValue=1)
     */
    private $idNotesMatiere;

    /**
     * @var float|null
     *
     * @ORM\Column(name="note_min_classe", type="float", precision=10, scale=0, nullable=true)
     */
    private $noteMinClasse;

    /**
     * @var float|null
     *
     * @ORM\Column(name="note_max_classe", type="float", precision=10, scale=0, nullable=true)
     */
    private $noteMaxClasse;

    /**
     * @var float|null
     *
     * @ORM\Column(name="note_moy_classe", type="float", precision=10, scale=0, nullable=true)
     */
    private $noteMoyClasse;

    /**
     * @var float
     *
     * @ORM\Column(name="note_eleve", type="float", precision=10, scale=0, nullable=false)
     */
    private $noteEleve;

    /**
     * @var \Matiere
     *
     * @ORM\ManyToOne(targetEntity="Matiere")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="nom_matiere", referencedColumnName="nom_matiere")
     * })
     */
    private $nomMatiere;

    /**
     * @var \Option
     *
     * @ORM\ManyToOne(targetEntity="Option")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_option", referencedColumnName="id_option")
     * })
     */
    private $idOption;

    /**
     * @var \Candidature
     *
     * @ORM\ManyToOne(targetEntity="Candidature")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_campagne", referencedColumnName="id_campagne"),
     *   @ORM\JoinColumn(name="id_eleve", referencedColumnName="id_eleve")
     * })
     */
    private $idCampagne;

    public function getIdNotesMatiere(): ?int
    {
        return $this->idNotesMatiere;
    }

    public function getNoteMinClasse(): ?float
    {
        return $this->noteMinClasse;
    }

    public function setNoteMinClasse(?float $noteMinClasse): self
    {
        $this->noteMinClasse = $noteMinClasse;

        return $this;
    }

    public function getNoteMaxClasse(): ?float
    {
        return $this->noteMaxClasse;
    }

    public function setNoteMaxClasse(?float $noteMaxClasse): self
    {
        $this->noteMaxClasse = $noteMaxClasse;

        return $this;
    }

    public function getNoteMoyClasse(): ?float
    {
        return $this->noteMoyClasse;
    }

    public function setNoteMoyClasse(?float $noteMoyClasse): self
    {
        $this->noteMoyClasse = $noteMoyClasse;

        return $this;
    }

    public function getNoteEleve(): ?float
    {
        return $this->noteEleve;
    }

    public function setNoteEleve(float $noteEleve): self
    {
        $this->noteEleve = $noteEleve;

        return $this;
    }

    public function getNomMatiere(): ?Matiere
    {
        return $this->nomMatiere;
    }

    public function setNomMatiere(?Matiere $nomMatiere): self
    {
        $this->nomMatiere = $nomMatiere;

        return $this;
    }

    public function getIdOption(): ?Option
    {
        return $this->idOption;
    }

    public function setIdOption(?Option $idOption): self
    {
        $this->idOption = $idOption;

        return $this;
    }

    public function getIdCampagne(): ?Candidature
    {
        return $this->idCampagne;
    }

    public function setIdCampagne(?Candidature $idCampagne): self
    {
        $this->idCampagne = $idCampagne;

        return $this;
    }


}
