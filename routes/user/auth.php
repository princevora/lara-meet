<?php

use App\Livewire\User\Auth\Login;
use App\Livewire\User\Auth\Logout;
use App\Livewire\User\Auth\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function(){
    Route::get('register', Register::class)->name('register');
    Route::get('login', Login::class)->name('login');
});

Route::middleware('auth')->group(function(){
    Route::get('logout', function(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');

    })->name('logout');
});