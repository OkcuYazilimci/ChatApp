<?php

namespace Tests\Application\Services;

use ChatApp\Application\Services\MessageService;
use ChatApp\Domain\Entities\User;
use ChatApp\Domain\Repositories\GroupRepositoryInterface;
use ChatApp\Domain\Repositories\MessageRepositoryInterface;
use ChatApp\Domain\Services\MessageServiceInterface;
use ChatApp\Domain\Services\UserServiceInterface;
use ChatApp\Domain\Entities\Message;
use PHPUnit\Framework\TestCase;

class MessageServiceTest extends TestCase
{
    private MessageServiceInterface $messageService;
    private MessageRepositoryInterface $messageRepositoryMock;
    private GroupRepositoryInterface $groupRepositoryMock;
    private UserServiceInterface $userServiceMock;

    protected function setUp(): void
    {
        $this->messageRepositoryMock = $this->createMock(MessageRepositoryInterface::class);
        $this->groupRepositoryMock = $this->createMock(GroupRepositoryInterface::class);
        $this->userServiceMock = $this->createMock(UserServiceInterface::class);

        $this->messageService = new MessageService(
            $this->messageRepositoryMock,
            $this->groupRepositoryMock,
            $this->userServiceMock
        );
    }

    public function testAddMessageSuccessfully()
    {
        $userId = "123";
        $groupId = "456";
        $content = "Hello, World!";

        $this->userServiceMock
            ->method('getUserById')
            ->with($userId)
            ->willReturn(new User([
                'id' => $userId,
                'username' => 'testuser'
            ]));

        $this->groupRepositoryMock
            ->method('isUserInGroup')
            ->with($userId, $groupId)
            ->willReturn(true);

        $this->messageRepositoryMock
            ->method('create')
            ->willReturn(new Message([
                'id' => '789',
                'user_id' => $userId,
                'group_id' => $groupId,
                'content' => $content
            ]));

        $message = $this->messageService->addMessage($userId, $groupId, $content);

        $this->assertNotNull($message);
        $this->assertEquals('789', $message->id);
        $this->assertEquals($content, $message->content);
    }
}
