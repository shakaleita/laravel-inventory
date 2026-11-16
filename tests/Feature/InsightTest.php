<?php
namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class InsightTest extends TestCase {
    use RefreshDatabase;
    public function test_insights_endpoint_is_public_read_only(): void {
        $response = $this->get('/api/insights');
        $response->assertOk()->assertJsonStructure(['products','low_stock','inventory_value_cents','stock_movements']);
    }
}
