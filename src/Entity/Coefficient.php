<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Coefficient
 *
 * @ORM\Table(name="coefficient", indexes={@ORM\Index(name="IDX_3F061B61659B5C82", columns={"nom_matiere"}), @ORM\Index(name="IDX_3F061B61340B183", columns={"id_campagne"}), @ORM\Index(name="IDX_3F061B61D8FC7127", columns={"nom_section"})})
 * @ORM\Entity(repositoryClass="App\Repository\CoefficientRepository")
 */
class Coefficient
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_coefficient", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="coefficient_id_coefficient_seq", allocationSize=1, initialValue=1)
     */
    private $idCoefficient;

    /**
     * @var float
     *
     * @ORM\Column(name="valeur", type="float", precision=10, scale=0, nullable=false)
     */
    private $valeur;

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

    public function getIdCoefficient(): ?int
    {
        return $this->idCoefficient;
    }

    public function getValeur(): ?float
    {
        return $this->valeur;
    }

    public function setValeur(float $valeur): self
    {
        $this->valeur = $valeur;

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


}
