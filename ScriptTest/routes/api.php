<?php

use App\Http\Controllers\EpresenceController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/register', [UserController::class, 'register'])->name('register');

Route::middleware('auth:sanctum')->group(function () {
    // Get all user data
    Route::get('/user', [UserController::class, 'index'])->middleware('auth:sanctum');

    // Get all presence data grouped by date
    Route::get('/presence', [EpresenceController::class, 'index']);

    // Store presence data
    Route::post('/presence', [EpresenceController::class, 'store']);

    // Approve or reject presence data
    Route::put('/presence/{id}', [EpresenceController::class, 'approval']);
});
