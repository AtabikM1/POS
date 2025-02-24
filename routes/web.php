<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/', function(){
    return view('welcome');
});

Route::get('level', [LevelController::class,'index']);


// Route::prefix('category')->group(function () {
//     Route::get('/', [ProductController::class, 'index'])->name('category.index');
//     Route::get('/food-beverage', [ProductController::class, 'foodBeverage']);
//     Route::get('/beauty-health', [ProductController::class, 'beautyHealth']);
//     Route::get('/home-care', [ProductController::class, 'homeCare']);
//     Route::get('/baby-kid', [ProductController::class, 'babyKid']);
// });

// Route:: get('/', function () {
// return view( 'welcome');
// });
// Route::get('/level', [LevelController::class, 'index']);
// Route::get ('/kategori', [KategoriController::class,'index' ]);
// Route::get ('/user', [UserController::class,'index']);
