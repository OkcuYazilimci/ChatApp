<?php

namespace ChatApp\Presentation\Controllers;

use ChatApp\Domain\Services\UserServiceInterface;
use ChatApp\Infrastructure\Utils\ResponseHelper;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController
{
    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function createUser(Request $request, Response $response): Response
    {
        $data = json_decode($request->getBody()->getContents(), true);

        if (empty($data['username'])) {
            return ResponseHelper::jsonResponse(['error' => 'Username is required'], 400);
        }

        $user = $this->userService->createUser($data['username']);

        return ResponseHelper::jsonResponse([
            'user_id' => $user->id,
            'username' => $user->username,
        ]);
    }

    public function getUser(Request $request, Response $response, array $args): Response
    {
        $userId = $args['user_id'] ?? null;

        if (!$userId) {
            return ResponseHelper::jsonResponse(['error' => 'User ID is required'], 400);
        }

        $user = $this->userService->getUserById($userId);

        if (!$user) {
            return ResponseHelper::jsonResponse(['error' => 'User not found'], 404);
        }

        return ResponseHelper::jsonResponse([
            'user_id' => $user->id,
            'username' => $user->username
        ]);
    }
}
