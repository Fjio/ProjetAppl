<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Calendrier
 *
 * @ORM\Table(name="calendrier", indexes={@ORM\Index(name="IDX_B2753CB9340B183", columns={"id_campagne"})})
 * @ORM\Entity(repositoryClass="App\Repository\CalendrierRepository")
 */
class Calendrier
{
    /**
     * @var string
     *
     * @ORM\Column(name="code_jalon", type="string", nullable=false, options={"comment"="Code permettant d'identifier l'évènement"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $codeJalon;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var string|null
     *
     * @ORM\Column(name="desc_jalon", type="string", nullable=true, options={"comment"="Description de l'évènement (ouverture/clôture du serveur, publication des résultats d'admissibilité/d'admission, ...) pour l'affichage sur l'interface utilisateur"})
     */
    private $descJalon;

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

    public function getCodeJalon(): ?string
    {
        return $this->codeJalon;
    }

    public function setCodeJalon(string $codeJalon): self
    {
        $this->codeJalon = $codeJalon;

        return $this;
    }



    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDescJalon(): ?string
    {
        return $this->descJalon;
    }

    public function setDescJalon(?string $descJalon): self
    {
        $this->descJalon = $descJalon;

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


}
