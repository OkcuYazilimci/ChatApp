<?php

require __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->safeLoad();

require_once __DIR__ . '/../Infrastructure/Database/Database.php';

use Slim\Factory\AppFactory;

$container = require __DIR__ . '/../Infrastructure/DI/Container.php';
AppFactory::setContainer($container);
$app = AppFactory::create();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

(require __DIR__ . '/../Presentation/Routes/Routes.php')($app);

$app->run();
