<?php
namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
class ReorderReportTest extends TestCase {
 use RefreshDatabase;
 public function test_replenishment_proposal_is_correct_and_excludes_healthy_stock():void {
  Product::create(['sku'=>'LOW-01','name'=>'Low stock','quantity'=>3,
   'reorder_level'=>5,'unit_cost_cents'=>250]);
  Product::create(['sku'=>'OK-01','name'=>'Healthy stock','quantity'=>20,
   'reorder_level'=>5,'unit_cost_cents'=>250]);
  $response=$this->get('/api/reorder-report');
  $response->assertOk()->assertJsonCount(1)
   ->assertJsonPath('0.sku','LOW-01')
   ->assertJsonPath('0.suggested_quantity',7)
   ->assertJsonPath('0.estimated_cost_cents',1750);
 }
}
