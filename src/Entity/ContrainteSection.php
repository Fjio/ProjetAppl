<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContrainteSection
 *
 * @ORM\Table(name="contrainte_section", indexes={@ORM\Index(name="IDX_F0A04021340B183", columns={"id_campagne"}), @ORM\Index(name="IDX_F0A04021D8FC7127", columns={"nom_section"})})
 * @ORM\Entity(repositoryClass="App\Repository\ContrainteSectionRepository")
 */
class ContrainteSection
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_contrainte_section", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="contrainte_section_id_contrainte_section_seq", allocationSize=1, initialValue=1)
     */
    private $idContrainteSection;

    /**
     * @var string
     *
     * @ORM\Column(name="message_contrainte", type="string", nullable=false, options={"comment"="Message affiché aux candidats leur indiquant les profils (spécialités et options suivies) qui peuvent candidater à cette section"})
     */
    private $messageContrainte;

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

    public function getIdContrainteSection(): ?int
    {
        return $this->idContrainteSection;
    }

    public function getMessageContrainte(): ?string
    {
        return $this->messageContrainte;
    }

    public function setMessageContrainte(string $messageContrainte): self
    {
        $this->messageContrainte = $messageContrainte;

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
