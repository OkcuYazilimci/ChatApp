<?php

namespace ChatApp\Infrastructure\Repositories;

use ChatApp\Domain\Repositories\UserRepositoryInterface;
use ChatApp\Domain\Entities\User;
use Illuminate\Support\Str;

class UserRepository implements UserRepositoryInterface
{
    public function findById(string $userId): ?User
    {
        return User::find($userId);
    }

    public function create(string $username, string $authToken): User
    {
        $user = new User();
        $user->id = (string) Str::uuid();
        $user->username = $username;

        $user->save();

        return $user;
    }
}
