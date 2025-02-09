<?php

namespace ChatApp\Domain\Repositories;

use ChatApp\Application\DTOs\CreateMessageDTO;
use ChatApp\Domain\Entities\Message;

interface MessageRepositoryInterface
{
    public function create(CreateMessageDTO $dto): ?Message;
    public function getMessagesByGroup(string $groupId, int $perPage = 100, int $page = 1);
}
