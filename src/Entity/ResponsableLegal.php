<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ResponsableLegal
 *
 * @ORM\Table(name="responsable_legal", indexes={@ORM\Index(name="IDX_82F3E53268B3575F", columns={"qualite"})})
 * @ORM\Entity(repositoryClass="App\Repository\ResponsableLegalRepository")
 */
class ResponsableLegal
{
    /**
     * @var \QualiteResponsableLegal
     *
     * @ORM\ManyToOne(targetEntity="QualiteResponsableLegal")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="qualite", referencedColumnName="qualite")
     * })
     */
    private $qualite;

    /**
     * @var \Personne
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Personne")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_responsable", referencedColumnName="id_personne")
     * })
     */
    private $idResponsable;

    public function getQualite(): ?QualiteResponsableLegal
    {
        return $this->qualite;
    }

    public function setQualite(?QualiteResponsableLegal $qualite): self
    {
        $this->qualite = $qualite;

        return $this;
    }

    public function getIdResponsable(): ?Personne
    {
        return $this->idResponsable;
    }

    public function setIdResponsable(?Personne $idResponsable): self
    {
        $this->idResponsable = $idResponsable;

        return $this;
    }


}
