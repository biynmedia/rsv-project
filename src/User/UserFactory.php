<?php


namespace App\User;


use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFactory
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Transform UserRequest into User
     * @param UserRequest $req
     * @return User
     */
    public function createFromUserRequest(UserRequest $req): User
    {
        $user = new User();
        $user->setFirstname($req->firstname)
            ->setLastname($req->lastname)
            ->setEmail($req->email)
            ->setRoles($req->roles)
            ->setRegistrationDate($req->registrationDate)
            ->setPassword($this->encoder->encodePassword($user, $req->password))
            ->setReceiveNotification($req->receiveNotification);

        return $user;
    }

}