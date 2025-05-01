<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Models\Client;
use App\Models\User;

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

    Route::prefix('check-ins')->name('check-ins.')->group(function () {
        Route::get('/', function () {
            return view('check-ins.index');
        })->name('index');
    });

    // Grupo de rutas para memberships
    Route::prefix('memberships')->name('memberships.')->group(function () {
        Route::get('/', function () {
            return view('memberships.index');
        })->name('index');

        Route::get('/create', function () {
            return view('memberships.create');
        })->name('create');
    });

    Route::prefix('staff')->name('staff.')->middleware(['can:manage gym staff'])->group(function () {
        Route::get('/', function () {
            return view('staff.index');
        })->name('index');

        Route::get('/{staffMember}', function (User $staffMember) {
            return view('staff.show', compact('staffMember'));
        })->name('show');
    });

    Route::prefix('clients')->name('clients.')->group(function () {
        Route::get('/', function () {
            return view('clients.index');
        })->name('index');
        
        Route::get('/create', function () {
            return view('clients.create');
        })->name('create');

        Volt::route('/{client}', 'client.show')->name('show');
        Volt::route('/{client}/subscriptions', 'client.subscriptions')->name('subscriptions');
        Volt::route('/{client}/check-ins', 'client.check-ins')->name('check-ins');
        Volt::route('/{client}/subscription-history', 'client.subscription-history')->name('subscription-history');
        Route::get('/{client}/edit', function (App\Models\Client $client) {
            return view('clients.edit', compact('client'));
        })->name('edit');
    });

    Route::get('/reports', function () {
        return view('reports');
    })->name('reports');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/clients', function () {
        return view('clients.index');
    })->name('clients.index');

    Route::get('/clients/create', function () {
        return view('clients.create');
    })->name('clients.create');

    Route::get('/clients/{client}/edit', function (App\Models\Client $client) {
        return view('clients.edit', compact('client'));
    })->name('clients.edit');
});

require __DIR__.'/auth.php';
