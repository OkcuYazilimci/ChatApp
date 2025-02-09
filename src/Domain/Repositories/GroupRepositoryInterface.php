<?php

namespace ChatApp\Domain\Repositories;

use ChatApp\Application\DTOs\CreateGroupDTO;
use ChatApp\Domain\Entities\Group;
use Illuminate\Pagination\LengthAwarePaginator;

interface GroupRepositoryInterface
{
    public function findById(string $groupId): ?Group;
    public function create(CreateGroupDTO $groupName): Group;
    public function isUserInGroup(string $userId, string $groupId): bool;
    public function getAllGroups(int $perPage = 10, int $page = 1): LengthAwarePaginator;
}
