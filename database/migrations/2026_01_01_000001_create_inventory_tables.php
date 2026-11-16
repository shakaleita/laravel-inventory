<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up():void {
  Schema::create('products',function(Blueprint $table){$table->id();$table->string('sku')->unique();$table->string('name');$table->unsignedInteger('quantity')->default(0);$table->unsignedInteger('reorder_level')->default(5);$table->unsignedInteger('unit_cost_cents')->default(0);$table->timestamps();});
  Schema::create('stock_movements',function(Blueprint $table){$table->id();$table->foreignId('product_id')->constrained()->cascadeOnDelete();$table->integer('change');$table->string('reason');$table->timestamps();});
 }
 public function down():void {Schema::dropIfExists('stock_movements');Schema::dropIfExists('products');}
};
