<?php
namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
class InventoryWorkflowTest extends TestCase {
 use RefreshDatabase;
 public function test_products_and_inventory_adjustment(): void {
  $this->post('/products', ['sku'=>'INV-100','name'=>'Monitor','quantity'=>8,'reorder_level'=>3,'unit_cost_cents'=>10000])->assertRedirect();
  $item=Product::where('sku','INV-100')->firstOrFail();
  $this->assertSame(8,(int)$item->quantity);
  $this->post('/products/'.$item->id.'/adjust',['change'=>-3,'reason'=>'Dispatch'])->assertRedirect();
  $this->assertSame(5,(int)$item->fresh()->quantity);
  $this->post('/products/'.$item->id.'/adjust',['change'=>-99,'reason'=>'Invalid'])->assertSessionHasErrors('change');
  $this->assertSame(5,(int)$item->fresh()->quantity);
 }
}
