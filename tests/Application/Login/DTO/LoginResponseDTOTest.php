<?php

namespace Tests\Application\Login\DTO;

use PHPUnit\Framework\TestCase;
use App\Application\Login\DTO\LoginResponseDTO;

class LoginResponseDTOTest extends TestCase
{
    public function testToArray()
    {
        $token = 'sample_token';
        $loginResponseDTO = new LoginResponseDTO($token);

        $expectedArray = [
            'token' => $token
        ];

        $this->assertEquals($expectedArray, $loginResponseDTO->toArray());
    }
}