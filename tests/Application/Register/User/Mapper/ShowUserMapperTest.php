<?php

namespace Tests\Application\Register\User\Mapper;

use App\Application\Register\User\Mapper\ShowUserMapper;
use App\Domain\Interfaces\Settings\Group\GroupRepositoryInterface;
use App\Models\Register\User\User;
use App\Models\Settings\Group\Group;
use PHPUnit\Framework\TestCase;

class ShowUserMapperTest extends TestCase
{
    private GroupRepositoryInterface $groupRepositoryMock;

    private ShowUserMapper $useCase;

    protected function setUp(): void
    {
        $this->groupRepositoryMock = $this->createMock(GroupRepositoryInterface::class);

        $this->useCase = new ShowUserMapper(
            $this->groupRepositoryMock
        );
    }

    public function testToOutputDto()
    {
        $user = new User();
        $user->id = 1;
        $user->username = 'testuser';
        $user->name = 'Test User';
        $user->email = 'test@example.com';
        $user->phone_number = '1234567890';
        $user->date_of_birth = '2000-01-01';
        $user->cpf_number = '12345678901';
        $user->gender = 'male';
        $user->path_image = 'path/to/image';
        $user->is_professional = true;
        $user->group_id = 1;
        $user->status = 'active';

        $group = new Group();
        $group->name = 'Test Group';

        $this->groupRepositoryMock->expects($this->once())->method('getById')->willReturn($group);

        $this->useCase->toOutputDto($user);
    }
}
