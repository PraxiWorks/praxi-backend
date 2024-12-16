<?php

namespace Tests\Application\DTO;

use App\Application\DTO\IdRequestDTO;
use Tests\TestCase;

class IdRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new IdRequestDTO(1);
        $this->assertEquals(1, $input->getId());
    }
}
