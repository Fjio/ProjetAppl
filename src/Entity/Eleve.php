<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Eleve
 *
 * @ORM\Table(name="eleve", indexes={@ORM\Index(name="IDX_ECA105F75F15257A", columns={"id_personne"}), @ORM\Index(name="IDX_ECA105F74A40C0F0", columns={"id_responsable"})})
 * @ORM\Entity(repositoryClass="App\Repository\EleveRepository")
 */
class Eleve
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_eleve", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="eleve_id_eleve_seq", allocationSize=1, initialValue=1)
     */
    private $idEleve;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_naissance", type="date", nullable=false)
     */
    private $dateNaissance;

    /**
     * @var \Personne
     *
     * @ORM\ManyToOne(targetEntity="Personne")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_personne", referencedColumnName="id_personne")
     * })
     */
    private $idPersonne;

    /**
     * @var \ResponsableLegal
     *
     * @ORM\ManyToOne(targetEntity="ResponsableLegal")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_responsable", referencedColumnName="id_responsable")
     * })
     */
    private $idResponsable;

    public function getIdEleve(): ?int
    {
        return $this->idEleve;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getIdPersonne(): ?Personne
    {
        return $this->idPersonne;
    }

    public function setIdPersonne(?Personne $idPersonne): self
    {
        $this->idPersonne = $idPersonne;

        return $this;
    }

    public function getIdResponsable(): ?ResponsableLegal
    {
        return $this->idResponsable;
    }

    public function setIdResponsable(?ResponsableLegal $idResponsable): self
    {
        $this->idResponsable = $idResponsable;

        return $this;
    }


}
