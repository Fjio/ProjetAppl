<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Personne;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 */
class Utilisateur implements UserInterface
{
    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", nullable=false)
     */
    private $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="roles", type="string", nullable=false)
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", nullable=false,unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="creationDate", type="date", nullable=false)
     */
    private $creationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="validatedUser", type="boolean", nullable=false)
     */
    private $validatedUser;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", nullable=false)
     */
    private $token;
    /**
     * @var Personne
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Personne")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_personne", referencedColumnName="id_personne")
     * })
     */
    private $idPersonne;

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function getValidatedUser()
    {
        return $this->validatedUser;
    }

    public function setValidatedUser($validatedUser)
    {
        $this->validatedUser = $validatedUser;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }
    
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): ?array
    {
        return [$this->roles];
    }

    public function setRoles(string $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getIdPersonne(): int
    {
        return $this->idPersonne->getIdPersonne();
    }

    public function setIdPersonne(?Personne $idPersonne): self
    {
        $this->idPersonne = $idPersonne;

        return $this;
    }

    public function eraseCredentials() {}

    public function getSalt()
    {
        return null;
    }


}
