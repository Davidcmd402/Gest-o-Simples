<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::resource('product', ProductController::class);
    Route::post('product/{product}/sell', [ProductController::class, 'sell'])->name('product.sell');
    Route::resource('supplier', SupplierController::class);
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
});