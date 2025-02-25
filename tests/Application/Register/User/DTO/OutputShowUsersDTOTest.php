<?php

namespace Tests\Application\Register\User\DTO;

use PHPUnit\Framework\TestCase;
use App\Application\Register\User\DTO\OutputShowUsersDTO;

class OutputShowUsersDTOTest extends TestCase
{
    public function testToArray()
    {
        $dto = new OutputShowUsersDTO(
            1,
            'John',
            'John Doe',
            'email',
            '1234567890',
            'dateOfBirth',
            'cpfNumber',
            'gender',
            'pathImage',
            true,
            'group',
            true
        );

        $expectedArray = [
            'id' => 1,
            'username' => 'John',
            'name' => 'John Doe',
            'email' => 'email',
            'phone_number' => '1234567890',
            'date_of_birth' => 'dateOfBirth',
            'cpf_number' => 'cpfNumber',
            'gender' => 'gender',
            'path_image' => 'pathImage',
            'is_professional' => true,
            'group' => 'group',
            'status' => true
        ];

        $this->assertEquals($expectedArray, $dto->toArray());
    }
}
