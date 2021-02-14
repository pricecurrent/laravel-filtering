<?php

use App\Http\Controllers\ProductsController;

Route::get('products', [ProductsController::class, 'index'])->name('products.index');
