<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use ChatApp\Presentation\Controllers\UserController;

return function (App $app) {
    $app->group('/users', function (RouteCollectorProxy $group) {
        $group->post('/signup', [UserController::class, 'createUser']);
        $group->get('/{user_id}', [UserController::class, 'getUser']);
    });
};
