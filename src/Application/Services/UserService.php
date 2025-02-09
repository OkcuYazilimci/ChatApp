<?php

namespace ChatApp\Application\Services;

use ChatApp\Domain\Services\UserServiceInterface;
use ChatApp\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Support\Str;

class UserService implements UserServiceInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(string $username)
    {
        return $this->userRepository->create($username, (string) Str::uuid());
    }

    public function getUserById(string $userId)
    {
        return $this->userRepository->findById($userId);
    }
}
