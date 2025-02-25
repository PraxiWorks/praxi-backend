<?php

namespace Tests\Application\Register\User\DTO;

use App\Application\Register\User\DTO\CreateUserRequestDTO;
use Tests\TestCase;

class CreateUserRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new CreateUserRequestDTO(
            1,
            'username',
            'name',
            'email',
            'phoneNumber',
            'dateOfBirth',
            'cpfNumber',
            'gender',
            true,
            true,
            true,
            'imageBase64',
            'password',
            false,
            1,
            true
        );
        $this->assertEquals(1, $input->getCompanyId());
        $this->assertEquals('username', $input->getUsername());
        $this->assertEquals('name', $input->getName());
        $this->assertEquals('email', $input->getEmail());
        $this->assertEquals('phoneNumber', $input->getPhoneNumber());
        $this->assertEquals('dateOfBirth', $input->getDateOfBirth());
        $this->assertEquals('cpfNumber', $input->getCpfNumber());
        $this->assertEquals('gender', $input->getGender());
        $this->assertTrue($input->getSendNotificationEmail());
        $this->assertTrue($input->getSendNotificationSms());
        $this->assertTrue($input->getStatus());
        $this->assertEquals('imageBase64', $input->getImageBase64());
        $this->assertEquals('password', $input->getPassword());
        $this->assertFalse($input->getIsProfessional());
        $this->assertEquals(1, $input->getGroupId());
        $this->assertTrue($input->getStatus());
    }
}
