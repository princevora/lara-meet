<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::prefix('meet')
    ->group(function () {
        return require_once __DIR__ . '/meet/web.php';
    });

Route::prefix('user')->name('user.')->group(function (){
    Route::prefix('auth')->name('auth.')->group(function (){
        return require_once __DIR__ . '/user/auth.php';
    });
});