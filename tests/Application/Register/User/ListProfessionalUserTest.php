<?php

namespace Tests\Application\Register\User;

use App\Application\DTO\IdRequestDTO;
use App\Application\Register\User\ListProfessionalUser;
use App\Domain\Interfaces\Register\User\UserRepositoryInterface;
use Tests\TestCase;

class ListProfessionalUserTest extends TestCase
{
    private UserRepositoryInterface $userRepositoryInterfaceMock;

    private ListProfessionalUser $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryInterfaceMock = $this->createMock(UserRepositoryInterface::class);

        $this->useCase = new ListProfessionalUser(
            $this->userRepositoryInterfaceMock
        );
    }

    public function testExecuteReturnsExpectedProfessionalUserList()
    {
        // Define o valor de retorno esperado do método list
        $products = $this->productsMock();

        $input = new IdRequestDTO(1);
        $this->userRepositoryInterfaceMock->expects($this->once())->method('listProfessionalUserByCompanyId')->willReturn($products);

        $result = $this->useCase->execute($input);

        // Verifica se o resultado é o esperado
        $this->assertEquals($products, $result);
    }

    public function productsMock()
    {
        return [
            [
                "id" => 2,
                "company_id" => 1,
                "name" => "Example Product",
                "category_id" => null,
                "sku_code" => "EX1234",
                "price" => "99.99",
                "path_image" => "images/usuarios/default.png",
                "status" => true,
                "current_stock" => "50",
                "minimum_stock_level" => "10",
                "maximum_stock_level" => "100",
                "created_at" => "2024-12-22T22:38:44.000000Z",
                "updated_at" => "2024-12-22T22:38:44.000000Z"
            ],
            [
                "id" => 3,
                "company_id" => 1,
                "name" => "Example Product",
                "category_id" => null,
                "sku_code" => "EX1234",
                "price" => "99.99",
                "path_image" => "images/usuarios/default.png",
                "status" => true,
                "current_stock" => "50",
                "minimum_stock_level" => "10",
                "maximum_stock_level" => "100",
                "created_at" => "2024-12-22T22:38:44.000000Z",
                "updated_at" => "2024-12-22T22:38:44.000000Z"
            ],
        ];
    }
}
