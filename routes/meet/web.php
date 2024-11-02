<?php

use App\Livewire\User\Meet\AddName;
use App\Livewire\User\Meet\Connect;
use Illuminate\Support\Facades\Route;

Route::name('meet.')->group(callback: function () {
    Route::get('{code}/add-name', AddName::class)->name('add-name');
    Route::get('{code}/connect', Connect::class)->name('connect');
});