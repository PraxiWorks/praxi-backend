<?php

namespace Tests\Application\Register\Client\DTO;

use App\Application\Register\Client\DTO\CreateClientRequestDTO;
use Tests\TestCase;

class CreateClientRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new CreateClientRequestDTO(
            1,
            'name',
            'email',
            'phoneNumber',
            'dateOfBirth',
            'cpfNumber',
            'rgNumber',
            'gender',
            true,
            true,
            true,
            'imageBase64',
            'password',
            false,
            true
        );

        $this->assertEquals(1, $input->getCompanyId());
        $this->assertEquals('name', $input->getName());
        $this->assertEquals('email', $input->getEmail());
        $this->assertEquals('phoneNumber', $input->getPhoneNumber());
        $this->assertEquals('dateOfBirth', $input->getDateOfBirth());
        $this->assertEquals('cpfNumber', $input->getCpfNumber());
        $this->assertEquals('rgNumber', $input->getRgNumber());
        $this->assertEquals('gender', $input->getGender());
        $this->assertTrue($input->getSendNotificationEmail());
        $this->assertTrue($input->getSendNotificationSms());
        $this->assertTrue($input->getSendNotificationWhatsapp());
        $this->assertTrue($input->getStatus());
        $this->assertEquals('imageBase64', $input->getImageBase64());
        $this->assertEquals('password', $input->getPassword());
        $this->assertFalse($input->getHasAccessToTheSystem());
        $this->assertTrue($input->getStatus());
    }
}
