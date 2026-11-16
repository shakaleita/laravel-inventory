<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;

class InventoryBoundsTest extends TestCase {
 use RefreshDatabase;

 public function test_stock_bounds_preserve_transaction_history(): void {
  $this->post('/products',['sku'=>'QTY-100','name'=>'Demo hardware',
    'quantity'=>2,'reorder_level'=>1,'unit_cost_cents'=>500])->assertRedirect();
  $product=Product::where('sku','QTY-100')->firstOrFail();
  $prior=$product->movements()->count();
  $this->post('/products/'.$product->id.'/adjust',
    ['change'=>1000000,'reason'=>'Oversized adjustment'])->assertSessionHasErrors('change');
  $this->assertSame(2,(int)$product->fresh()->quantity);
  $this->assertSame($prior,$product->movements()->count());
  $this->post('/products/'.$product->id.'/adjust',
    ['change'=>-3,'reason'=>'Insufficient stock'])->assertSessionHasErrors('change');
  $this->assertSame(2,(int)$product->fresh()->quantity);
 }
 public function test_product_valuation_inputs_are_bounded(): void {
  $this->post('/products',['sku'=>'TOO-LARGE','name'=>'Too large',
    'quantity'=>1000001,'reorder_level'=>1,'unit_cost_cents'=>500])
    ->assertSessionHasErrors('quantity');
  $this->post('/products',['sku'=>'TOO-EXPENSIVE','name'=>'Too expensive',
    'quantity'=>1,'reorder_level'=>1,'unit_cost_cents'=>100000001])
    ->assertSessionHasErrors('unit_cost_cents');
 }
}
