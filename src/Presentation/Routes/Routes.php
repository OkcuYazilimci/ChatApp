<?php

use Slim\App;

return function (App $app) {
    (require __DIR__ . '/UserRoutes.php')($app);
    (require __DIR__ . '/GroupRoutes.php')($app);
    (require __DIR__ . '/MessageRoutes.php')($app);
};
