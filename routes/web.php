<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::prefix('meet')->middleware('auth')->group(function () {
        require_once __DIR__ . '/meet/web.php';
    });

Route::prefix('user')->name('user.')->group(function () {
    Route::prefix('auth')->middleware('guest')->name('auth.')->group(function () {
        require_once __DIR__ . '/user/auth.php';
    });
});