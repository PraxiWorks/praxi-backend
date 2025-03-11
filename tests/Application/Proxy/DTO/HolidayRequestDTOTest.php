<?php

namespace Tests\Application\Proxy\DTO;

use App\Application\Proxy\DTO\HolidayRequestDTO;
use Tests\TestCase;

class HolidayRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new HolidayRequestDTO(02, 2022);

        $this->assertEquals(02, $input->getMonth());
        $this->assertEquals(2022, $input->getYear());
    }
}
