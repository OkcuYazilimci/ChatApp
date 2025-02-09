<?php

namespace ChatApp\Domain\Repositories;

use ChatApp\Domain\Entities\User;

interface UserRepositoryInterface
{
    public function findById(string $userId): ?User;
    public function create(string $username, string $authToken): User;
}
