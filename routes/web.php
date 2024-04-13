<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ShopController;
use App\Http\Middleware\AdminAuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [AdminAuthController::class, 'getLogin'])->name('adminLogin');
    Route::post('/login', [AdminAuthController::class, 'postLogin'])->name('adminLoginPost');
    Route::post('/logout', [AdminAuthController::class, 'adminLogout'])->name('logout');
    
    Route::middleware([AdminAuthMiddleware::class])->group(function () {
        Route::get('/', [AdminAuthController::class, 'dashboard'])->name('adminDashboard');
        Route::resource('shop', ShopController::class);
        Route::get('product/export-csv',[ProductController::class,'export'])->name('productExport');
        Route::get('product/export-template',[ProductController::class,'download_template'])->name('productTemplate');
        Route::get('product/import-csv',[ProductController::class,'import'])->name('productImport');
        Route::post('product/import-csv',[ProductController::class,'import_product'])->name('productImportAction');
        Route::resource('product', ProductController::class);
    });
});