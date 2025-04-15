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
    
    // Ruta para la página de suscripciones
    Route::view('subscriptions', 'subscriptions')
        ->middleware(['auth', 'verified'])
        ->name('subscriptions');

    Route::view('subscriptions/create', 'createSubscription')
        ->middleware(['auth', 'verified'])
        ->name('createSubscription');

    Route::view('check-ins', 'check-ins')
        ->middleware(['auth', 'verified'])
        ->name('check-ins');

    Route::view('memberships', 'memberships')
        ->middleware(['auth', 'verified'])
        ->name('memberships');
});

require __DIR__.'/auth.php';
