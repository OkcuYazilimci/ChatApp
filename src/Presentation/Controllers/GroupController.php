<?php

namespace ChatApp\Presentation\Controllers;

use ChatApp\Domain\Services\GroupServiceInterface;
use ChatApp\Infrastructure\Utils\ResponseHelper;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GroupController
{
    private GroupServiceInterface $groupService;

    public function __construct(GroupServiceInterface $groupService)
    {
        $this->groupService = $groupService;
    }

    public function createGroup(Request $request, Response $response): Response
    {
        $data = json_decode($request->getBody()->getContents(), true);

        if (empty($data['name'])) {
            return ResponseHelper::jsonResponse(['error' => 'Group name is required'], 400);
        }

        if (empty($data['user_id'])) {
            return ResponseHelper::jsonResponse(['error' => 'User ID is required'], 400);
        }

        try {

            $result = $this->groupService->createGroup($data['user_id'], $data['name'], $data['description'] ?? '');

            return ResponseHelper::jsonResponse($result);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(['error' => 'Invalid data: ' . $e->getMessage()], 400);
        }
    }

    public function joinGroup(Request $request, Response $response): Response
    {
        $data = json_decode($request->getBody()->getContents(), true);

        if (empty($data['user_id']) || empty($data['group_id'])) {
            return ResponseHelper::jsonResponse(['error' => 'User ID and Group ID are required'], 400);
        }

        $result = $this->groupService->joinGroup($data['user_id'], $data['group_id']);

        return ResponseHelper::jsonResponse($result);
    }

    public function getAllGroups(Request $request, Response $response): Response
    {
        $queryParams = $request->getQueryParams();
        $perPage = isset($queryParams['per_page']) && is_numeric($queryParams['per_page']) ? (int) $queryParams['per_page'] : 10;
        $page = isset($queryParams['page']) && is_numeric($queryParams['page']) ? (int) $queryParams['page'] : 1;

        $groups = $this->groupService->getAllGroups($perPage, $page);

        return ResponseHelper::jsonResponse([
            'current_page' => $groups->currentPage(),
            'total_pages' => $groups->lastPage(),
            'total_groups' => $groups->total(),
            'groups' => $groups->items(),
        ]);
    }
}
