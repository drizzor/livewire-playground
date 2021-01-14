<?php

use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Profile;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'dashboard');

/**
 * App Routes
 */
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard.index');
    Route::get('/profile', Profile::class)->name('dashboard.profile');
});

/**
 * Authentification
 */
Route::middleware('guest')->group(function () {
    Route::get('/register', Register::class)->name('auth.register');
    Route::get('/login', Login::class)->name('auth.login');
});
