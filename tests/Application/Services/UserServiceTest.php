<?php

namespace Tests\Application\Services;

use ChatApp\Application\Services\UserService;
use ChatApp\Domain\Repositories\UserRepositoryInterface;
use ChatApp\Domain\Services\UserServiceInterface;
use ChatApp\Domain\Entities\User;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    private UserServiceInterface $userService;
    private UserRepositoryInterface $userRepositoryMock;

    protected function setUp(): void
    {
        $this->userRepositoryMock = $this->createMock(UserRepositoryInterface::class);

        $this->userService = new UserService(
            $this->userRepositoryMock
        );
    }

    public function testCreateUserSuccessfully()
    {
        $username = "testuser";

        $this->userRepositoryMock
            ->method('create')
            ->willReturn(new User([
                'id' => '123',
                'username' => $username
            ]));

        $user = $this->userService->createUser($username);

        $this->assertNotNull($user);
        $this->assertEquals('testuser', $user->username);
    }

    public function testGetUserById()
    {
        $userId = "123";

        $this->userRepositoryMock
            ->method('findById')
            ->with($userId)
            ->willReturn(new User([
                'id' => $userId,
                'username' => 'testuser'
            ]));

        $user = $this->userService->getUserById($userId);

        $this->assertNotNull($user);
        $this->assertEquals($userId, $user->id);
        $this->assertEquals('testuser', $user->username);
    }
}
