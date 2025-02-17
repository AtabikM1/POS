<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;


Route::get('/', [HomeController::class, 'index'])->name('home');




Route::prefix('category')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('category.index');
    Route::get('/food-beverage', [ProductController::class, 'foodBeverage']);
    Route::get('/beauty-health', [ProductController::class, 'beautyHealth']);
    Route::get('/home-care', [ProductController::class, 'homeCare']);
    Route::get('/baby-kid', [ProductController::class, 'babyKid']);
});


Route::get('/user/{id}/name/{name}', [UserController::class, 'show'])->name('user.show');


Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
