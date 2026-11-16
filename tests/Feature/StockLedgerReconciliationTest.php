<?php
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockLedgerReconciliationTest extends TestCase {
 use RefreshDatabase;
 public function test_detects_reconciled_and_out_of_balance_stock():void {
  $this->post('/products',['sku'=>'RECON-1','name'=>'Drives',
    'quantity'=>8,'reorder_level'=>2,'unit_cost_cents'=>250])->assertRedirect();
  $product=Product::where('sku','RECON-1')->firstOrFail();
  $this->post('/products/'.$product->id.'/adjust',
    ['change'=>-3,'reason'=>'Fulfilment'])->assertRedirect();
  $this->get('/api/reconciliation')->assertOk()
    ->assertJsonPath('checked',1)
    ->assertJsonPath('mismatched',0)
    ->assertJsonPath('products.0.ledger_quantity',5);
  $product->update(['quantity'=>9]);
  $this->get('/api/reconciliation')->assertOk()
    ->assertJsonPath('mismatched',1)
    ->assertJsonPath('products.0.difference',4)
    ->assertJsonPath('products.0.matches',false);
 }
}
