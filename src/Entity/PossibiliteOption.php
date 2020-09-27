<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PossibiliteOption
 *
 * @ORM\Table(name="possibilite_option", indexes={@ORM\Index(name="IDX_7FE5EE0B659B5C82", columns={"nom_matiere"}), @ORM\Index(name="IDX_7FE5EE0B340B183", columns={"id_campagne"}), @ORM\Index(name="IDX_7FE5EE0BD8FC7127", columns={"nom_section"}), @ORM\Index(name="IDX_7FE5EE0B7CB1B55D", columns={"id_option"})})
 * @ORM\Entity
 */
class PossibiliteOption
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_possibilite_option", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="possibilite_option_id_possibilite_option_seq", allocationSize=1, initialValue=1)
     */
    private $idPossibiliteOption;

    /**
     * @var float|null
     *
     * @ORM\Column(name="coefdifferent", type="float", precision=10, scale=0, nullable=true, options={"comment"="Bypass le coefficient de la table Coefficient pour le calcul de la moyenne"})
     */
    private $coefdifferent;

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
     * @var \Campagne
     *
     * @ORM\ManyToOne(targetEntity="Campagne")
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
     * @var \Option
     *
     * @ORM\ManyToOne(targetEntity="Option")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_option", referencedColumnName="id_option")
     * })
     */
    private $idOption;

    public function getIdPossibiliteOption(): ?int
    {
        return $this->idPossibiliteOption;
    }

    public function getCoefdifferent(): ?float
    {
        return $this->coefdifferent;
    }

    public function setCoefdifferent(?float $coefdifferent): self
    {
        $this->coefdifferent = $coefdifferent;

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

    public function getIdOption(): ?Option
    {
        return $this->idOption;
    }

    public function setIdOption(?Option $idOption): self
    {
        $this->idOption = $idOption;

        return $this;
    }


}
