<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index']);
// ROUTE UNTUK LEVEL (DIPISAH)
Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']); 
    Route::post('/list', [LevelController::class, 'list']); 
    Route::get('/create', [LevelController::class, 'create']); 
    Route::post('/store', [LevelController::class, 'store']); 
    Route::get('/edit/{id}', [LevelController::class, 'edit']); 
    Route::post('/update/{id}', [LevelController::class, 'update']); 
    Route::delete('/delete/{id}', [LevelController::class, 'destroy']); 
});
// ROUTE UNTUK USER
Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']); 
    Route::post('/list', [UserController::class, 'list']);
    Route::get('/create', [UserController::class, 'create']); 
    Route::post('/', [UserController::class, 'store']); 
    Route::get('/{id}', [UserController::class, 'show']); 
    Route::get('/{id}/edit', [UserController::class, 'edit']); 
    Route::put('/{id}', [UserController::class, 'update']); 
    Route::delete('/{id}', [UserController::class, 'destroy']); 
});
//ROUTE GRUP KATEGORI BARANG
Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']); 
    Route::get('/kategori/list', [KategoriController::class, 'list']);
    Route::get('/create', [KategoriController::class, 'create']); 
    Route::post('/', [KategoriController::class, 'store']); 
    Route::get('/{id}', [KategoriController::class, 'show']); 
    Route::get('/{id}/edit', [KategoriController::class, 'edit']); 
    Route::put('/{id}', [KategoriController::class, 'update']); 
    Route::delete('/{id}', [KategoriController::class, 'destroy']); 
});


