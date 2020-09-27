<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AnneeScolaire
 *
 * @ORM\Table(name="annee_scolaire", indexes={@ORM\Index(name="IDX_97150C2B340B18322444C7", columns={"id_campagne", "id_eleve"})})
 * @ORM\Entity(repositoryClass="App\Repository\AnneeScolaireRepository")
 */
class AnneeScolaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_annee_scolaire", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="annee_scolaire_id_annee_scolaire_seq", allocationSize=1, initialValue=1)
     */
    private $idAnneeScolaire;

    /**
     * @var string
     *
     * @ORM\Column(name="etablissement", type="string", length=50, nullable=false)
     */
    private $etablissement;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_rue", type="string", nullable=false)
     */
    private $numeroRue;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_rue", type="string", nullable=false)
     */
    private $nomRue;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", nullable=false)
     */
    private $ville;

    /**
     * @var int
     *
     * @ORM\Column(name="code_postal", type="integer", nullable=false)
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", nullable=false)
     */
    private $pays;

    /**
     * @var int
     *
     * @ORM\Column(name="annee", type="integer", nullable=false)
     */
    private $annee;

    /**
     * @var string
     *
     * @ORM\Column(name="classe", type="string", length=20, nullable=false)
     */
    private $classe;

    /**
     * @var string|null
     *
     * @ORM\Column(name="specialite", type="string", length=20, nullable=true)
     */
    private $specialite;

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

    public function getIdAnneeScolaire(): ?int
    {
        return $this->idAnneeScolaire;
    }

    public function getEtablissement(): ?string
    {
        return $this->etablissement;
    }

    public function setEtablissement(string $etablissement): self
    {
        $this->etablissement = $etablissement;

        return $this;
    }

    public function getNumeroRue(): ?string
    {
        return $this->numeroRue;
    }

    public function setNumeroRue(string $numeroRue): self
    {
        $this->numeroRue = $numeroRue;

        return $this;
    }

    public function getNomRue(): ?string
    {
        return $this->nomRue;
    }

    public function setNomRue(string $nomRue): self
    {
        $this->nomRue = $nomRue;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->codePostal;
    }

    public function setCodePostal(int $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
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

    public function getClasse(): ?string
    {
        return $this->classe;
    }

    public function setClasse(string $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(?string $specialite): self
    {
        $this->specialite = $specialite;

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
