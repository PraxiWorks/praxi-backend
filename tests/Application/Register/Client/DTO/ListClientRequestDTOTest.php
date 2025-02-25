<?php

namespace Tests\Application\Register\Client\DTO;

use App\Application\Register\Client\DTO\ListClientRequestDTO;
use Tests\TestCase;

class ListClientRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new ListClientRequestDTO(
            1,
            true,
            'searchQuery',
            1,
            15
        );

        $this->assertEquals(1, $input->getCompanyId());
        $this->assertEquals(true, $input->getStatus());
        $this->assertEquals('searchQuery', $input->getSearchQuery());
        $this->assertEquals(1, $input->getPage());
        $this->assertEquals(15, $input->getPerPage());
    }
}
