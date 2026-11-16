<?php
namespace Tests\Feature;
use Tests\TestCase;
class CsvExportTest extends TestCase {
 public function test_csv_export_has_headers_and_columns(): void {
  $response=$this->get('/api/export/inventory-products.csv');
  $response->assertOk();
  $response->assertHeader('content-type','text/csv; charset=UTF-8');
  $this->assertStringContainsString('id', $response->streamedContent());
 }
}
