<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScannerController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Login untuk masing-masing inventory type
Route::get('/login/{type}', [AuthController::class, 'showLoginForm'])
    ->where('type', 'it|alkes|rt')
    ->name('login.form');
    
Route::post('/login/{type}', [AuthController::class, 'login'])
    ->where('type', 'it|alkes|rt')
    ->name('login');

// Route yang memerlukan login
Route::middleware('auth.session')->group(function () {
    Route::get('/scanner', [ScannerController::class, 'index'])
        ->name('scanner');
    Route::post('/get-item', [ScannerController::class, 'getItemDetail'])
        ->name('get.item');
    Route::post('/supervisi', [ScannerController::class, 'supervisi'])
        ->name('supervisi');
});

// Logout (bisa diakses tanpa middleware)
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');
