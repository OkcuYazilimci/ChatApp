<?php

namespace ChatApp\Domain\Services;

interface UserServiceInterface
{
    public function createUser(string $username);
    public function getUserById(string $userId);
}
