<?php


namespace App\User;

use Symfony\Component\Validator\Constraints as Assert;

class UserRequest
{
    public $id;

    /**
     * @Assert\NotBlank(message="Saisissez votre Prénom.")
     * @Assert\Length(max="80", maxMessage="Votre prénom ne peux pas dépasser {{ limit }} caractères.")
     */
    public $firstname;

    /**
     * @Assert\NotBlank(message="Saisissez votre Nom.")
     * @Assert\Length(max="80", maxMessage="Votre nom ne peux pas dépasser {{ limit }} caractères.")
     */
    public $lastname;

    /**
     * @Assert\NotBlank(message="Saisissez votre Email.")
     * @Assert\Length(max="80", maxMessage="Votre email ne peux pas dépasser {{ limit }} caractères.")
     * @Assert\Email(message="Vérifiez le format de votre email.")
     */
    public $email;

    /**
     * @Assert\NotBlank(message="Choisissez un mot de passe.")
     * @Assert\Length(
     *     min="8",
     *     minMessage="Votre mot de passe est trop court. {{ limit }} caractères min.",
     *     max="20",
     *     maxMessage="Votre mot de passe est trop long. {{ limit }} caractères max."
     * )
     */
    public $password;
    public $roles = [];
    public $registrationDate;
    public $lastConnectionDate;
    public $lastConnectionIp;
    public $receiveNotification;

    public function __construct()
    {
        $this->registrationDate = new \DateTime();
    }

    /**
     * Add new role to user
     * @param string $role
     * @return UserRequest
     */
    public function addRole(string $role): self
    {
        if (!in_array($role, $this->roles)) {
            $this->roles[] = $role;
        }
        return $this;
    }

}
