<?php

use App\Http\Controllers\LikeController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\RetweetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('like', LikeController::class)->only(['create', 'destroy']);
    Route::resource('reply', ReplyController::class)->only(['create', 'destroy']);
    Route::resource('retweet', RetweetController::class)->only(['create', 'destroy']);
});
