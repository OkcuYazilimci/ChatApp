<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use ChatApp\Presentation\Controllers\MessageController;

return function (App $app) {
    $app->group('/messages', function (RouteCollectorProxy $group) {
        $group->post('/{group_id}', [MessageController::class, 'sendMessage']);
        $group->get('/{group_id}', [MessageController::class, 'getMessages']);
    });
};
