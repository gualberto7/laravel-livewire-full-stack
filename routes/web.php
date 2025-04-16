<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Route::prefix('subscriptions')->name('subscriptions.')->group(function () {
        Route::get('/', function () {
            return view('subscriptions.index');
        })->name('index');
        Route::get('/create', function () {
            return view('subscriptions.create');
        })->name('create');
    });

    Route::view('check-ins', 'check-ins')
        ->middleware(['auth', 'verified'])
        ->name('check-ins');

    // Grupo de rutas para memberships
    Route::prefix('memberships')->name('memberships.')->group(function () {
        Route::get('/', function () {
            return view('memberships.index');
        })->name('index');

        Route::get('/create', function () {
            return view('memberships.create');
        })->name('create');
    });
});

require __DIR__.'/auth.php';
