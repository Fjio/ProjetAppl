<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Option
 *
 * @ORM\Table(name="option")
 * @ORM\Entity
 */
class Option
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_option", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="option_id_option_seq", allocationSize=1, initialValue=1)
     */
    private $idOption;

    /**
     * @var string
     *
     * @ORM\Column(name="acronyme_option", type="string", nullable=false)
     */
    private $acronymeOption;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_entier", type="string", length=70, nullable=false)
     */
    private $nomEntier;

    /**
     * @var bool
     *
     * @ORM\Column(name="est_specialite", type="boolean", nullable=false)
     */
    private $estSpecialite;

    /**
     * @var bool
     *
     * @ORM\Column(name="est_option", type="boolean", nullable=false)
     */
    private $estOption;

    public function getIdOption(): ?int
    {
        return $this->idOption;
    }

    public function getAcronymeOption(): ?string
    {
        return $this->acronymeOption;
    }

    public function setAcronymeOption(string $acronymeOption): self
    {
        $this->acronymeOption = $acronymeOption;

        return $this;
    }

    public function getNomEntier(): ?string
    {
        return $this->nomEntier;
    }

    public function setNomEntier(string $nomEntier): self
    {
        $this->nomEntier = $nomEntier;

        return $this;
    }

    public function getEstSpecialite(): ?bool
    {
        return $this->estSpecialite;
    }

    public function setEstSpecialite(bool $estSpecialite): self
    {
        $this->estSpecialite = $estSpecialite;

        return $this;
    }

    public function getEstOption(): ?bool
    {
        return $this->estOption;
    }

    public function setEstOption(bool $estOption): self
    {
        $this->estOption = $estOption;

        return $this;
    }


}
