<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Campagne
 *
 * @ORM\Table(name="campagne")
 * @ORM\Entity(repositoryClass="App\Repository\CampagneRepository")
 */
class Campagne
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_campagne", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="campagne_id_campagne_seq", allocationSize=1, initialValue=1)
     */
    private $idCampagne;

    /**
     * @var int
     *
     * @ORM\Column(name="annee", type="integer", nullable=false, options={"comment"="2019, 2020, ..."})
     */
    private $annee;

    /**
     * @var float
     *
     * @ORM\Column(name="coef_note_moyenne_generale", type="float", precision=10, scale=0, nullable=false)
     */
    private $coefNoteMoyenneGenerale;

    /**
     * @var float
     *
     * @ORM\Column(name="coef_note_autobiographie", type="float", precision=10, scale=0, nullable=false)
     */
    private $coefNoteAutobiographie;

    /**
     * @var float
     *
     * @ORM\Column(name="coef_note_appreciation_dossier", type="float", precision=10, scale=0, nullable=false)
     */
    private $coefNoteAppreciationDossier;

    /**
     * @var int
     *
     * @ORM\Column(name="note_max_autobiographie", type="integer", nullable=false)
     */
    private $noteMaxAutobiographie;

    /**
     * @var int
     *
     * @ORM\Column(name="note_max_appreciation_dossier", type="integer", nullable=false)
     */
    private $noteMaxAppreciationDossier;

    /**
     * @var int
     *
     * @ORM\Column(name="note_max_moyenne_generale", type="integer", nullable=false)
     */
    private $noteMaxMoyenneGenerale;

    public function getIdCampagne(): ?int
    {
        return $this->idCampagne;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getCoefNoteMoyenneGenerale(): ?float
    {
        return $this->coefNoteMoyenneGenerale;
    }

    public function setCoefNoteMoyenneGenerale(float $coefNoteMoyenneGenerale): self
    {
        $this->coefNoteMoyenneGenerale = $coefNoteMoyenneGenerale;

        return $this;
    }

    public function getCoefNoteAutobiographie(): ?float
    {
        return $this->coefNoteAutobiographie;
    }

    public function setCoefNoteAutobiographie(float $coefNoteAutobiographie): self
    {
        $this->coefNoteAutobiographie = $coefNoteAutobiographie;

        return $this;
    }

    public function getCoefNoteAppreciationDossier(): ?float
    {
        return $this->coefNoteAppreciationDossier;
    }

    public function setCoefNoteAppreciationDossier(float $coefNoteAppreciationDossier): self
    {
        $this->coefNoteAppreciationDossier = $coefNoteAppreciationDossier;

        return $this;
    }

    public function getNoteMaxAutobiographie(): ?int
    {
        return $this->noteMaxAutobiographie;
    }

    public function setNoteMaxAutobiographie(int $noteMaxAutobiographie): self
    {
        $this->noteMaxAutobiographie = $noteMaxAutobiographie;

        return $this;
    }

    public function getNoteMaxAppreciationDossier(): ?int
    {
        return $this->noteMaxAppreciationDossier;
    }

    public function setNoteMaxAppreciationDossier(int $noteMaxAppreciationDossier): self
    {
        $this->noteMaxAppreciationDossier = $noteMaxAppreciationDossier;

        return $this;
    }

    public function getNoteMaxMoyenneGenerale(): ?int
    {
        return $this->noteMaxMoyenneGenerale;
    }

    public function setNoteMaxMoyenneGenerale(int $noteMaxMoyenneGenerale): self
    {
        $this->noteMaxMoyenneGenerale = $noteMaxMoyenneGenerale;

        return $this;
    }


}
