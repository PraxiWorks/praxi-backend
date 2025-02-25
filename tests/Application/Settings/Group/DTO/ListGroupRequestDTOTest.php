<?php

namespace Tests\Application\Settings\Group\DTO;

use App\Application\Settings\Group\DTO\ListGroupRequestDTO;
use Tests\TestCase;

class ListGroupRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new ListGroupRequestDTO(1, true, 'name', 1, 2);

        $this->assertEquals(1, $input->getCompanyId());
        $this->assertEquals(true, $input->getStatus());
        $this->assertEquals('name', $input->getSearchQuery());
        $this->assertEquals(1, $input->getPage());
        $this->assertEquals(2, $input->getPerPage());
    }
}
