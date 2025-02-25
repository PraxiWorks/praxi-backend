<?php

namespace Tests\Application\Register\User\DTO;

use App\Application\Register\User\DTO\ListUserRequestDTO;
use Tests\TestCase;

class ListUserRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new ListUserRequestDTO(
            1,
            true,
            'searchQuery',
            1,
            10
        );

        $this->assertEquals(1, $input->getCompanyId());
        $this->assertTrue($input->getStatus());
        $this->assertEquals('searchQuery', $input->getSearchQuery());
        $this->assertEquals(1, $input->getPage());
        $this->assertEquals(10, $input->getPerPage());
    }
}
