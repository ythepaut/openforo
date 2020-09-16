<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *     fields = {"email", "username"},
 *     message = "L'email ou le nom d'utilisateur est déjà utilisé"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 3,
     *      max = 16,
     *      minMessage = "Votre nom d'utilisateur doit faire au moins {{ limit }} caractères.",
     *      maxMessage = "Votre nom d'utilisateur ne doit pas excéder {{ limit }} caractères.",
     *      allowEmptyString = false
     * )
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 8,
     *      minMessage = "Votre mot de passe doit faire au moins {{ limit }} caractères.",
     *      allowEmptyString = false
     * )
     */
    private $passwd;

    /**
     * @Assert\EqualTo(
     *     propertyPath="passwd",
     *     message = "Les deux mots de passe doivent être identiques"
     * )
     */
    private $confirm_passwd;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $salt;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPasswd(): ?string
    {
        return $this->passwd;
    }

    public function setPasswd(string $passwd): self
    {
        $this->passwd = $passwd;

        return $this;
    }

    public function getConfirmPasswd(): ?string
    {
        return $this->confirm_passwd;
    }

    public function setConfirmPasswd(string $confirm_passwd): self
    {
        $this->confirm_passwd = $confirm_passwd;

        return $this;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getPassword()
    {
        return $this->getPasswd();
    }

    public function getSalt()
    {
        return $this->getSalt();
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}
