<?php


namespace App\User;


use Doctrine\ORM\EntityManagerInterface;

class UserRequestHandler
{
    private $manager, $userFactory;

    public function __construct(EntityManagerInterface $manager, UserFactory $userFactory)
    {
        $this->manager = $manager;
        $this->userFactory = $userFactory;
    }

    public function registerAsUser(UserRequest $userRequest)
    {
        # Give user right
        $userRequest->addRole('ROLE_USER');

        # Create user from request
        $user = $this->userFactory->createFromUserRequest($userRequest);

        # Persist data
        $this->manager->persist($user);
        $this->manager->flush();

        # TODO : Dispatch User Event

        # Return user
        return $user;

    }

    public function registerAsMinistry(UserRequest $userRequest)
    {
        # Give user right
        $userRequest->addRole('ROLE_MINISTRY');

        # Create user from request
        $user = $this->userFactory->createFromUserRequest($userRequest);

        # Persist data
        $this->manager->persist($user);
        $this->manager->flush();

        # TODO : Dispatch User Event

        # Return user
        return $user;
    }

    public function registerAsAdmin(UserRequest $userRequest)
    {
        # Give user right
        $userRequest->addRole('ROLE_ADMIN');

        # Create user from request
        $user = $this->userFactory->createFromUserRequest($userRequest);

        # Persist data
        $this->manager->persist($user);
        $this->manager->flush();

        # TODO : Dispatch User Event

        # Return user
        return $user;
    }

}