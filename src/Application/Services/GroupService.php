<?php

namespace ChatApp\Application\Services;

use ChatApp\Domain\Services\UserServiceInterface;
use ChatApp\Application\DTOs\CreateGroupDTO;
use ChatApp\Domain\Repositories\GroupRepositoryInterface;
use ChatApp\Domain\Services\GroupServiceInterface;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class GroupService implements GroupServiceInterface
{
    private GroupRepositoryInterface $groupRepository;
    private UserServiceInterface $userService;

    public function __construct(GroupRepositoryInterface $groupRepository, UserServiceInterface $userService)
    {
        $this->groupRepository = $groupRepository;
        $this->userService = $userService;
    }

    /**
     * @throws Exception
     */
    public function createGroup(string $userId, string $name, string $description = ''): array
    {
        $dto = new CreateGroupDTO($name, $userId, $description);
        $user = $this->userService->getUserById($dto->user_id);

        if ($user === null) {
            throw new Exception("User not found");
        }

        $group = $this->groupRepository->create($dto);

        if (empty($group->id)) {
            throw new Exception("Failed to create group");
        }

        $this->joinGroup($userId, $group->id);
        return ['group_id' => $group->id, 'name' => $group->name ?? ""];
    }

    public function joinGroup(string $userId, string $groupId): array
    {
        $user = $this->userService->getUserById($userId);
        $group = $this->groupRepository->findById($groupId);

        if (!$user || !$group) {
            return ['error' => 'User or group not found'];
        }

        $group->refresh();
        $groupName = $group->name ?? 'Unnamed Group';

        if ($group->members()->where('user_id', $userId)->exists()) {
            return ['error' => "User {$user->username} is already in the group: {$groupName}"];
        }

        try {
            $group->members()->attach($userId);
            $group->increment('member_number');

            return ['message' => "{$user->username} joined the group: {$groupName} successfully"];
        } catch (\Exception $e) {
            return ['error' => 'Failed to join the group: ' . $e->getMessage()];
        }
    }

    public function getAllGroups(int $perPage = 10, int $page = 1): LengthAwarePaginator
    {
        return $this->groupRepository->getAllGroups($perPage, $page);
    }
}
