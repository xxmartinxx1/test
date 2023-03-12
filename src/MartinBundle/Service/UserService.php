<?php

namespace MartinBundle\Service;
use MartinBundle\Repository\UserRepository;

class UserService
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getOneUser(int $id)
    {
        return $this->userRepository->findOneUser($id);
    }

    public function getAllUser()
    {
        return $this->userRepository->findAllUser();
    }
}