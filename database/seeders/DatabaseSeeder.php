<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Product::query()->upsert([
            ['sku' => 'KB-001', 'name' => 'Wireless Keyboard', 'category' => 'Accessories', 'supplier' => 'TechSource', 'unit_price' => 24.99, 'quantity' => 18, 'reorder_level' => 5],
            ['sku' => 'MS-002', 'name' => 'Ergonomic Mouse', 'category' => 'Accessories', 'supplier' => 'TechSource', 'unit_price' => 18.50, 'quantity' => 4, 'reorder_level' => 5],
            ['sku' => 'MN-003', 'name' => '24-inch Monitor', 'category' => 'Displays', 'supplier' => 'ScreenWorks', 'unit_price' => 149.00, 'quantity' => 12, 'reorder_level' => 3],
        ], ['sku'], ['name', 'category', 'supplier', 'unit_price', 'quantity', 'reorder_level']);
    }
}
