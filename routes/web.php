<?php
use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;
Route::get('/',[InventoryController::class,'index'])->name('inventory.index');
Route::post('/products',[InventoryController::class,'store'])->name('products.store');
Route::post('/products/{product}/adjust',[InventoryController::class,'adjust'])->name('products.adjust');

Route::get('/api/insights',[InventoryController::class,'insights'])->name('inventory-insights');
