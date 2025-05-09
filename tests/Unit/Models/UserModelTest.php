<?php

use App\Models\Gym;
use App\Models\User;
use App\Models\Preference;

test('User has many gyms', function () {
    $user = User::factory()->create();
    $gym = Gym::factory()->create([
        'owner_id' => $user->id,
    ]);

    expect($user->ownedGyms->first())->toBeInstanceOf(Gym::class);
});

test('User is staff of a gym', function () {
    $user = User::factory()->create();
    $gym = Gym::factory()->create();
    $user->update(['gym_id' => $gym->id]);

    expect($user->staffGym)->toBeInstanceOf(Gym::class);
});

test('User can check if they own a gym', function () {
    $user = User::factory()->create();
    $gym = Gym::factory()->create([
        'owner_id' => $user->id,
    ]);

    expect($user->ownsGym($gym))->toBeTrue();
});

test('user has preferences', function () {
    $user = User::factory()->create();
    $user->preferences()->create([
        'preferable_id' => $user->id,
        'key' => 'test',
        'value' => 'test',
    ]);

    expect($user->preferences->first())->toBeInstanceOf(Preference::class);
});

test('user can get a preference', function () {
    $user = User::factory()->create();
    $user->preferences()->create([
        'preferable_id' => $user->id,
        'key' => 'test',
        'value' => 'test value',
    ]);

    expect($user->getPreference('test'))->toBe('test value');
});

test('user can set a preference', function () {
    $user = User::factory()->create();
    $user->setPreference('test', 'test value');

    expect($user->getPreference('test'))->toBe('test value');
});

test('user can get current gym', function () {
    $user = User::factory()->create();
    $gym = Gym::factory()->create([
        'name' => 'Test Gym',
        'owner_id' => $user->id,
    ]);

    expect($user->getCurrentGym()->name)->toBe('Test Gym');
});

test('user can set current gym', function () {
    $user = User::factory()->create();
    $gym = Gym::factory()->create([
        'name' => 'Test Gym',
        'owner_id' => $user->id,
    ]);

    $user->setCurrentGym($gym);

    expect($user->getCurrentGym()->name)->toBe('Test Gym');
});
