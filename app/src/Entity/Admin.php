<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
class Admin implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 20)]
    private $password;

    #[ORM\Column(type: 'string', length: 30)]
    private $email;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

     /**
     * this function is made so that interfaces are in accord with this entity
     *
     * @return string|null
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * this function is made so that interfaces are in accord with this entity
     *
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {

    }

    /**
     * 
     * this function is made so that interfaces are in accord with this entity
     * it gives the email as default
     *
     * @return string|null
     */
    public function getNickname(): ?string
    {
        return $this->email;
    }

    /**
     *
     * this function is made so that interfaces are in accord with this entity
     * it gives thi$ as default
     *
     * @return $this
     */
    public function setNickname(): self
    {
        return $this;
    }

    /**
     *
     * this function is made so that interfaces are in accord with this entity
     * it gives thi$ as default
     *
     * @return $this
     */
    public function getUserIdentifier(): self
    {
        return $this;
    }

    /**
     *
     * this function is made so that interfaces are in accord with this entity
     * it gives thi$ as default
     *
     * @return $this
     */
    public function getRoles(): self
    {
        return $this;
    }

    /**
     *
     * this function is made so that interfaces are in accord with this entity
     * it gives thi$ as default
     *
     * @return $string
     */
    public function getUsername(): string
    {
        return $this->email;
    }
}
