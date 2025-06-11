<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TweetController;

// Halaman Login dan Register
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Halaman utama setelah login
Route::get('/', function () {
    return redirect()->route('timeline'); // Redirect ke timeline setelah login
});

// Rute untuk Timeline (Hanya bisa diakses oleh pengguna yang sudah login)
Route::middleware('auth')->get('/timeline', [TweetController::class, 'index'])->name('timeline');

// Rute untuk menyimpan tweet (Hanya bisa diakses oleh pengguna yang sudah login)
Route::middleware('auth')->post('/tweets', [TweetController::class, 'store'])->name('tweets.store');

// Rute untuk menampilkan form edit tweet
Route::middleware('auth')->get('/tweets/{tweet}/edit', [TweetController::class, 'edit'])->name('tweets.edit');

// Rute untuk memperbarui tweet
Route::middleware('auth')->put('/tweets/{tweet}', [TweetController::class, 'update'])->name('tweets.update');

Route::middleware('auth')->delete('/tweets/{tweet}', [TweetController::class, 'destroy'])->name('tweets.destroy');

