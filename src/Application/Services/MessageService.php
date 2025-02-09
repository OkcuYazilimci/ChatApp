<?php

namespace ChatApp\Application\Services;

use ChatApp\Domain\Entities\Message;
use ChatApp\Domain\Repositories\GroupRepositoryInterface;
use ChatApp\Domain\Repositories\MessageRepositoryInterface;
use ChatApp\Application\DTOs\CreateMessageDTO;
use ChatApp\Domain\Services\MessageServiceInterface;
use ChatApp\Domain\Services\UserServiceInterface;
use Exception;

class MessageService implements MessageServiceInterface
{
    private MessageRepositoryInterface $messageRepository;
    private GroupRepositoryInterface $groupRepository;
    private UserServiceInterface $userService;

    public function __construct(MessageRepositoryInterface $messageRepository, GroupRepositoryInterface $groupRepository, UserServiceInterface $userService)
    {
        $this->messageRepository = $messageRepository;
        $this->groupRepository = $groupRepository;
        $this->userService = $userService;
    }

    public function addMessage(string $userId, string $groupId, string $content): ?Message
    {
        $user = $this->userService->getUserById($userId);

        if (!$user) {
            throw new Exception("User not found");
        }

        $isMember = $this->groupRepository->isUserInGroup($userId, $groupId);

        if (!$isMember) {
            throw new Exception("You must be a member of this group");
        }

        try {
            $dto = new CreateMessageDTO($userId, $groupId, $content);
            return $this->messageRepository->create($dto);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getMessagesByGroup(string $groupId, string $userId, int $perPage = 100, int $page = 1)
    {
        $user = $this->userService->getUserById($userId);

        if (!$user) {
            throw new Exception("User not found");
        }

        $isMember = $this->groupRepository->isUserInGroup($userId, $groupId);

        if (!$isMember) {
            throw new Exception("You must be a member of this group");
        }

        return $this->messageRepository->getMessagesByGroup($groupId, $perPage, $page);
    }
}
