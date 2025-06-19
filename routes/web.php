<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ProfileController;

// Halaman Auth
Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'showLoginForm')->name('login');
    Route::post('login', 'login');
    Route::get('register', 'showRegisterForm')->name('register');
    Route::post('register', 'register');
    Route::post('logout', 'logout')->name('logout');
});

// Redirect root ke timeline
Route::redirect('/', '/timeline');

// Rute yang membutuhkan auth
Route::middleware('auth')->group(function () {
    // Timeline Routes
    Route::controller(TweetController::class)->group(function () {
        Route::get('/timeline', 'index')->name('timeline');
        Route::post('/tweets', 'store')->name('tweets.store');
        Route::get('/tweets/{tweet}/edit', 'edit')->name('tweets.edit');
        Route::put('/tweets/{tweet}', 'update')->name('tweets.update');
        Route::delete('/tweets/{tweet}', 'destroy')->name('tweets.destroy');
        Route::get('/search', 'search')->name('tweets.search');
        Route::get('/trends', 'trends')->name('tweets.trends');
    });

    // Profile Routes
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/@{username}', 'show')->name('profile');
        Route::get('/@{username}/edit', 'edit')->name('profile.edit');
        Route::put('/@{username}/update', 'update')->name('profile.update');
    });

    // Follow System
    Route::controller(FollowController::class)->group(function () {
        Route::post('/users/{user}/follow', 'follow')->name('follow');
        Route::delete('/users/{user}/unfollow', 'unfollow')->name('unfollow');
        Route::get('/users/{user}/followers', 'followers')->name('followers');
        Route::get('/users/{user}/followings', 'followings')->name('followings');
    });
});