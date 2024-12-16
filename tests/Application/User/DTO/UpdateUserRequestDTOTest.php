<?php

namespace Tests\Application\User\DTO;

use App\Application\User\DTO\UpdateUserRequestDTO;
use Tests\TestCase;

class UpdateUserRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new UpdateUserRequestDTO(
            1,
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
            true
        );
        $this->assertEquals(1, $input->getId());
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
        $this->assertTrue($input->getStatus());
    }
}
