<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QualiteResponsableLegal
 *
 * @ORM\Table(name="qualite_responsable_legal")
 * @ORM\Entity(repositoryClass="App\Repository\QualiteResponsableLegalRepository")
 */
class QualiteResponsableLegal
{
    /**
     * @var string
     *
     * @ORM\Column(name="qualite", type="string", nullable=false, options={"comment"="Père, mère ou tuteur"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $qualite;

    public function getQualite(): ?string
    {
        return $this->qualite;
    }

    public function setQualite(string $qualite): self
    {
        $this->qualite = $qualite;

        return $this;
    }




}
