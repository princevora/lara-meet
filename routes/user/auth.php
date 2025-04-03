<?php

use App\Livewire\User\Auth\Login;
use App\Livewire\User\Auth\Register;
use Illuminate\Support\Facades\Route;

Route::get('register', Register::class)->name('register');
Route::get('login', Login::class)->name('login');