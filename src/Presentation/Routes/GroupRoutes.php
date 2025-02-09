<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use ChatApp\Presentation\Controllers\GroupController;
use ChatApp\Middleware\AuthMiddleware;
use ChatApp\Domain\Services\UserServiceInterface;

return function (App $app) {
    $app->group('/groups', function (RouteCollectorProxy $group) {
        $group->post('', [GroupController::class, 'createGroup']);
        $group->post('/join', [GroupController::class, 'joinGroup']);
        $group->get('', [GroupController::class, 'getAllGroups']);
    });
};
