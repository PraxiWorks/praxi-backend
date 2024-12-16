<?php

namespace Tests\Application\User\DTO;

use App\Application\User\DTO\CreateUserRequestDTO;
use Tests\TestCase;

class CreateUserRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new CreateUserRequestDTO(
            1,
            'name',
            'email',
            'phoneNumber',
            1,
            'dateOfBirth',
            'cpfNumber',
            'rgNumber',
            'gender',
            true,
            true,
            true,
            'imageBase64',
            'password',
            true
        );
        $this->assertEquals(1, $input->getCompanyId());
        $this->assertEquals('name', $input->getName());
        $this->assertEquals('email', $input->getEmail());
        $this->assertEquals('phoneNumber', $input->getPhoneNumber());
        $this->assertEquals(1, $input->getUserTypeId());
        $this->assertEquals('dateOfBirth', $input->getDateOfBirth());
        $this->assertEquals('cpfNumber', $input->getCpfNumber());
        $this->assertEquals('rgNumber', $input->getRgNumber());
        $this->assertEquals('gender', $input->getGender());
        $this->assertTrue($input->getSendNotificationEmail());
        $this->assertTrue($input->getSendNotificationSms());
        $this->assertTrue($input->getStatus());
        $this->assertEquals('imageBase64', $input->getImageBase64());
        $this->assertEquals('password', $input->getPassword());
        $this->assertTrue($input->getStatus());
    }
}
