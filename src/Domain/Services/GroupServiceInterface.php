<?php

namespace ChatApp\Domain\Services;

use Illuminate\Pagination\LengthAwarePaginator;

interface GroupServiceInterface
{
    public function createGroup(string $userId, string $name, string $description = ''): array;
    public function joinGroup(string $userId, string $groupId): array;
    public function getAllGroups(int $perPage = 10, int $page = 1): LengthAwarePaginator;
}
