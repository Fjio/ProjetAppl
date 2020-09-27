<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Matiere
 *
 * @ORM\Table(name="matiere")
 * @ORM\Entity(repositoryClass="App\Repository\MatiereRepository")
 */
class Matiere
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom_matiere", type="string", nullable=false)
     * @ORM\Id
     */
    private $nomMatiere;

    /**
     * @var string
     *
     * @ORM\Column(name="nature", type="string", nullable=false)
     */
    private $nature;

    public function getNomMatiere(): ?string
    {
        return $this->nomMatiere;
    }

    public function setNomMatiere(?String $nomMatiere): self
    {
        $this->nomMatiere = $nomMatiere;

        return $this;
    }

    public function getNature(): ?string
    {
        return $this->nature;
    }

    public function setNature(?String $nature): self
    {
        $this->nature = $nature;

        return $this;
    }


}
