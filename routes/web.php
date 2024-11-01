<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('meet')
    ->namespace('\App\Livewire')
    ->group(function () {
        return require_once __DIR__ . '/meet/web.php';
    });