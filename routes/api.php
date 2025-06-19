<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/register', [AuthController::class, 'registerApi']);
Route::post('/login', [AuthController::class, 'loginApi']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logoutApi']);

    // User routes
    Route::get('/me', [UserController::class, 'me']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/profile', [UserController::class, 'update']);
    Route::put('/users/password', [UserController::class, 'updatePassword']);
});

Route::get('trends', [TweetController::class, 'getTrends'])->name('api.trends');
