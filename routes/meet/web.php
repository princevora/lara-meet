<?php

use App\Livewire\User\Meet\AddName;
use App\Livewire\User\Meet\Connect;
use App\Livewire\User\Meet\Room;
use Illuminate\Support\Facades\Route;

Route::name('meet.')->group(function () {
    // Route::get('{code}/add-name', AddName::class)->name('add-name');
    Route::get('{code}', Connect::class)->name('connect');
    Route::get('{code}/room',Room::class)->name('room');
});