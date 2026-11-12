<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'dashboard'])->name('dashboard');
Route::resource('products', ProductController::class)->except(['show', 'edit']);
