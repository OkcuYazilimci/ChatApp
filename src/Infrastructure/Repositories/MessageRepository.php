<?php

namespace ChatApp\Infrastructure\Repositories;

use ChatApp\Domain\Repositories\MessageRepositoryInterface;
use ChatApp\Domain\Entities\Message;
use ChatApp\Application\DTOs\CreateMessageDTO;

class MessageRepository implements MessageRepositoryInterface
{
    public function create(CreateMessageDTO $dto): ?Message
    {
        try {
            error_log('Attempting to insert message: ' . json_encode($dto->toArray()));

            $message = Message::create($dto->toArray());

            if (!$message) {
                error_log('Message insert failed.');
            } else {
                error_log('Message inserted: ' . json_encode($message));
            }

            return $message;
        } catch (\Exception $e) {
            error_log('Error inserting message: ' . $e->getMessage());
            return null;
        }
    }

    public function getMessagesByGroup(string $groupId, int $perPage = 100, int $page = 1)
    {
        return Message::where('group_id', $groupId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);
    }
}
