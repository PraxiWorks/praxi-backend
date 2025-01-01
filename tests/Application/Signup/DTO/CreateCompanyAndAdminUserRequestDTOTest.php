<?php

namespace Tests\Application\Signup\DTO;

use App\Application\Signup\DTO\CreateCompanyAndAdminUserRequestDTO;
use Tests\TestCase;

class CreateCompanyAndAdminUserRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new CreateCompanyAndAdminUserRequestDTO(
            1,
            [],
            'Fantasy Name',
            'Username',
            'Name',
            'Email',
            'Phone Number',
            'Password',
            [1, 2, 3, 4]
        );
        $this->assertEquals(1, $input->getPlanId());
        $this->assertEquals([], $input->getModules());
        $this->assertEquals('Fantasy Name', $input->getFantasyName());
        $this->assertEquals('Username', $input->getUsername());
        $this->assertEquals('Name', $input->getName());
        $this->assertEquals('Email', $input->getEmail());
        $this->assertEquals('Phone Number', $input->getPhoneNumber());
        $this->assertEquals('Password', $input->getPassword());
        $this->assertEquals([1, 2, 3, 4], $input->getWorkSchedule());
    }
}
