<?php

namespace Database\Seeders\Permissions;

class StockPermissionsSeeder extends BasePermissionsSeeder
{
    protected function getModuleName(): string
    {
        return 'Stock';
    }

    protected function getPermissions(): array
    {
        return [
            ['display_name' => 'Listar Produtos', 'name' => 'stock.product.list'],
            ['display_name' => 'Criar Produto', 'name' => 'stock.product.store'],
            ['display_name' => 'Mostrar Produto', 'name' => 'stock.product.show'],
            ['display_name' => 'Atualizar Produto', 'name' => 'stock.product.update'],
            ['display_name' => 'Deletar Produto', 'name' => 'stock.product.delete'],

            ['display_name' => 'Listar Categorias', 'name' => 'stock.category.list'],
            ['display_name' => 'Criar Categoria', 'name' => 'stock.category.store'],
            ['display_name' => 'Mostrar Categoria', 'name' => 'stock.category.show'],
            ['display_name' => 'Atualizar Categoria', 'name' => 'stock.category.update'],
            ['display_name' => 'Deletar Categoria', 'name' => 'stock.category.delete'],

            ['display_name' => 'Listar Fornecedores', 'name' => 'stock.supplier.list'],
            ['display_name' => 'Criar Fornecedor', 'name' => 'stock.supplier.store'],
            ['display_name' => 'Mostrar Fornecedor', 'name' => 'stock.supplier.show'],
            ['display_name' => 'Atualizar Fornecedor', 'name' => 'stock.supplier.update'],
            ['display_name' => 'Deletar Fornecedor', 'name' => 'stock.supplier.delete']
        ];
    }
}
