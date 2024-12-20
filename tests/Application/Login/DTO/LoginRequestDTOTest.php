<?php

namespace Tests\Application\Login\DTO;

use App\Application\Login\DTO\LoginRequestDTO;
use Tests\TestCase;

class LoginRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new LoginRequestDTO('name', 'password');
        $this->assertEquals('name', $input->getUsername());
        $this->assertEquals('password', $input->getPassword());
    }
}
