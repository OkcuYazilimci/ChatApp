<?php

namespace ChatApp\Domain\Services;

use ChatApp\Domain\Entities\Message;

interface MessageServiceInterface
{
    public function addMessage(string $userId, string $groupId, string $content): ?Message;
    public function getMessagesByGroup(string $groupId, string $userId, int $perPage = 100, int $page = 1);
}
