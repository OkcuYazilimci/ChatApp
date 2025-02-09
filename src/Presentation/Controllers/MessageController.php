<?php

namespace ChatApp\Presentation\Controllers;

use ChatApp\Domain\Services\MessageServiceInterface;
use ChatApp\Infrastructure\Utils\ResponseHelper;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Exception;

class MessageController
{
    private MessageServiceInterface $messageService;

    public function __construct(MessageServiceInterface $messageService)
    {
        $this->messageService = $messageService;
    }

    public function sendMessage(Request $request, Response $response, array $args): Response
    {
        try {
            $data = json_decode($request->getBody()->getContents(), true);

            $userId = $data['user_id'] ?? null;
            $groupId = $args['group_id'] ?? null;

            if (!$groupId) {
                return ResponseHelper::jsonResponse(['error' => 'Group ID is required'], 400);
            }

            if (empty($data['content'])) {
                return ResponseHelper::jsonResponse(['error' => 'Message content is required'], 400);
            }

            $message = $this->messageService->addMessage($userId, $groupId, $data['content']);

            if (!$message) {
                return ResponseHelper::jsonResponse(['error' => 'Message could not be sent'], 400);
            }

            return ResponseHelper::jsonResponse([
                'message_id' => $message->id,
                'content' => $message->content
            ]);

        } catch (Exception $e) {
            return ResponseHelper::jsonResponse(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function getMessages(Request $request, Response $response, array $args): Response
    {
        try {
            $groupId = $args['group_id'] ?? null;

            $queryParams = $request->getQueryParams();
            $userId = $queryParams['user_id'] ?? $args['user_id'] ?? null;

            if (!$groupId) {
                return ResponseHelper::jsonResponse(['error' => 'Group ID is required'], 400);
            }

            if (!$userId) {
                return ResponseHelper::jsonResponse(['error' => 'User ID is required'], 400);
            }

            $page = isset($queryParams['page']) && is_numeric($queryParams['page']) ? (int) $queryParams['page'] : 1;

            $messages = $this->messageService->getMessagesByGroup($groupId, $userId, 100, $page);

            $formattedMessages = $messages->map(function ($message) {
                return [
                    'message_id' => $message->id,
                    'content' => $message->content,
                    'sender_name' => $message->user->username ?? 'Unknown',
                    'created_at' => $message->created_at->format('d-m-Y, H:i:s'),
                ];
            });

            return ResponseHelper::jsonResponse([
                'current_page' => $messages->currentPage(),
                'total_pages' => $messages->lastPage(),
                'total_messages' => $messages->total(),
                'messages' => $formattedMessages,
            ]);

        } catch (Exception $e) {
            return ResponseHelper::jsonResponse(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
