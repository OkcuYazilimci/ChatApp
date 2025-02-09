<?php

namespace Tests\Application\Services;

use ChatApp\Application\Services\GroupService;
use ChatApp\Domain\Repositories\GroupRepositoryInterface;
use ChatApp\Domain\Services\GroupServiceInterface;
use ChatApp\Domain\Services\UserServiceInterface;
use ChatApp\Domain\Entities\Group;
use ChatApp\Domain\Entities\User;
use PHPUnit\Framework\TestCase;

class GroupServiceTest extends TestCase
{
    private GroupServiceInterface $groupService;
    private GroupRepositoryInterface $groupRepositoryMock;
    private UserServiceInterface $userServiceMock;

    protected function setUp(): void
    {
        $this->groupRepositoryMock = $this->createMock(GroupRepositoryInterface::class);
        $this->userServiceMock = $this->createMock(UserServiceInterface::class);

        $this->groupService = new GroupService(
            $this->groupRepositoryMock,
            $this->userServiceMock
        );
    }

    public function testCreateGroupSuccessfully(): void
    {
        $mockUser = new User();
        $mockUser->id = 'user-123';
        $mockUser->username = 'TestUser';

        $this->userServiceMock->expects($this->atLeast(2))
        ->method('getUserById')
            ->with('user-123')
            ->willReturn($mockUser);

        $mockGroup = new Group();
        $mockGroup->id = 'group-456';
        $mockGroup->name = 'TestGroup';

        $this->groupRepositoryMock->expects($this->once())
            ->method('create')
            ->willReturn(new Group([
                'id' => 'group-456',
                'name' => 'TestGroup'
            ]));

        $result = $this->groupService->createGroup('user-123', 'TestGroup', 'A test group');

        $this->assertArrayHasKey('group_id', $result);
        $this->assertArrayHasKey('name', $result);
        $this->assertEquals('group-456', $result['group_id']);
        $this->assertEquals('TestGroup', $result['name']);
    }

    public function testCreateGroupFailsWhenUserNotFound(): void
    {
        $this->userServiceMock->expects($this->once())
            ->method('getUserById')
            ->with('user-999')
            ->willReturn(null);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("User not found");

        $this->groupService->createGroup('user-999', 'InvalidGroup', 'This should fail');
    }

    public function testCreateGroupFailsWhenGroupCreationFails(): void
    {
        $mockUser = new User();
        $mockUser->id = 'user-123';

        $this->userServiceMock->expects($this->once())
            ->method('getUserById')
            ->with('user-123')
            ->willReturn($mockUser);

        $this->groupRepositoryMock->expects($this->once())
            ->method('create')
            ->willReturn(new Group(['id' => '', 'name' => '']));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Failed to create group");

        $this->groupService->createGroup('user-123', 'InvalidGroup', 'This should fail');
    }
}
