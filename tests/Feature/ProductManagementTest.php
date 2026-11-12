<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_can_be_created(): void
    {
        $response = $this->post('/products', ['sku' => 'TEST-001', 'name' => 'Test Product', 'category' => 'General', 'supplier' => 'Supplier', 'unit_price' => 10.50, 'quantity' => 8, 'reorder_level' => 3]);
        $response->assertRedirect('/products');
        $this->assertDatabaseHas('products', ['sku' => 'TEST-001', 'quantity' => 8]);
    }

    public function test_product_creation_validates_required_fields(): void
    {
        $response = $this->post('/products', []);
        $response->assertSessionHasErrors(['sku', 'name', 'category', 'unit_price', 'quantity', 'reorder_level']);
    }

    public function test_low_stock_is_detected(): void
    {
        $product = Product::factory()->create(['quantity' => 2, 'reorder_level' => 5]);
        $this->assertTrue($product->isLowStock());
    }
}
