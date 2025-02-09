<?php

use DI\Container;
use Dotenv\Dotenv;
use ChatApp\Infrastructure\Repositories\UserRepository;
use ChatApp\Domain\Services\UserServiceInterface;
use ChatApp\Application\Services\UserService;
use ChatApp\Domain\Repositories\UserRepositoryInterface;
use ChatApp\Domain\Repositories\GroupRepositoryInterface;
use ChatApp\Infrastructure\Repositories\GroupRepository;
use ChatApp\Domain\Services\GroupServiceInterface;
use ChatApp\Application\Services\GroupService;
use ChatApp\Domain\Repositories\MessageRepositoryInterface;
use ChatApp\Infrastructure\Repositories\MessageRepository;
use ChatApp\Domain\Services\MessageServiceInterface;
use ChatApp\Application\Services\MessageService;
use Psr\Container\ContainerInterface;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();

$container = new Container();

// Register repositories
$container->set(UserRepositoryInterface::class, function () {
return new UserRepository();
});

$container->set(GroupRepositoryInterface::class, function () {
return new GroupRepository();
});

$container->set(MessageRepositoryInterface::class, function () {
return new MessageRepository();
});

// Register services
$container->set(UserServiceInterface::class, function ($container) {
return new UserService($container->get(UserRepositoryInterface::class));
});

$container->set(GroupServiceInterface::class, function ($container) {
return new GroupService(
$container->get(GroupRepositoryInterface::class),
$container->get(UserServiceInterface::class)
);
});

$container->set(MessageServiceInterface::class, function (ContainerInterface $c) {
    return new MessageService(
        $c->get(MessageRepositoryInterface::class),
        $c->get(GroupRepositoryInterface::class),
        $c->get(UserServiceInterface::class)
    );
});

return $container;
