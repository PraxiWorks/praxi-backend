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
            'stock.product.list',
            'stock.product.store',
            'stock.product.show',
            'stock.product.update',
            'stock.product.delete',

            'stock.category.list',
            'stock.category.store',
            'stock.category.show',
            'stock.category.update',
            'stock.category.delete',

            'stock.supplier.list',
            'stock.supplier.store',
            'stock.supplier.show',
            'stock.supplier.update',
            'stock.supplier.delete'
        ];
    }
}
