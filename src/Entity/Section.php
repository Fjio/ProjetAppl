<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Section
 *
 * @ORM\Table(name="section")
 * @ORM\Entity(repositoryClass="App\Repository\SectionRepository")
 */
class Section
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom_section", type="string", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $nomSection;

    public function getNomSection(): ?string
    {
        return $this->nomSection;
    }

    public function setNomSection(?string $nomSection): self
    {
        $this->nomSection = $nomSection;

        return $this;
    }



}
