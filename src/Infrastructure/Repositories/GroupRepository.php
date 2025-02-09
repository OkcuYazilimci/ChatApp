<?php

namespace ChatApp\Infrastructure\Repositories;

use ChatApp\Application\DTOs\CreateGroupDTO;
use ChatApp\Domain\Repositories\GroupRepositoryInterface;
use ChatApp\Domain\Entities\Group;
use Illuminate\Pagination\LengthAwarePaginator;

class GroupRepository implements GroupRepositoryInterface
{
    public function findById(string $groupId): ?Group
    {
        return Group::find($groupId);
    }

    public function create(CreateGroupDTO $groupDTO): Group
    {
        return Group::create($groupDTO->toArray());
    }

    public function isUserInGroup(string $userId, string $groupId): bool
    {
        return Group::where('id', $groupId)
            ->whereHas('members', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->exists();
    }

    public function getAllGroups(int $perPage = 10, int $page = 1): LengthAwarePaginator
    {
        return Group::orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);
    }
}
