<?php

namespace Tests\Application\Register\ClientAddress\DTO;

use App\Application\Register\ClientAddress\DTO\CreateClientAddressRequestDTO;
use Tests\TestCase;

class CreateClientAddressRequestDTOTest extends TestCase
{
    public function testInputDTO()
    {
        $input = new CreateClientAddressRequestDTO(
            1,
            'country',
            'zipCode',
            'state',
            'city',
            'neighborhood',
            'street',
            1,
            'complement'
        );

        $this->assertEquals(1, $input->getClientId());
        $this->assertEquals('country', $input->getCountry());
        $this->assertEquals('zipCode', $input->getZipCode());
        $this->assertEquals('state', $input->getState());
        $this->assertEquals('city', $input->getCity());
        $this->assertEquals('neighborhood', $input->getNeighborhood());
        $this->assertEquals('street', $input->getStreet());
        $this->assertEquals(1, $input->getNumber());
        $this->assertEquals('complement', $input->getComplement());
    }
}
