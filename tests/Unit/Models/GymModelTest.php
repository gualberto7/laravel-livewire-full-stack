<?php

use App\Models\Gym;
use App\Models\User;
use App\Models\Client;
use App\Models\Membership;
use App\Models\Subscription;

test('gym has an owner', function () {
    $gym = Gym::factory()->create();

    expect($gym->owner)->toBeInstanceOf(User::class);
});

test('gym has many users', function () {
    $gym = Gym::factory()->create();
    $users = User::factory(2)->create([
        'gym_id' => $gym->id,
    ]);

    expect($gym->users->first())->toBeInstanceOf(User::class);
});

test('gym has many clients', function () {
    $gym = Gym::factory()->create();
    $clients = Client::factory(2)->create([
        'gym_id' => $gym->id,
    ]);

    expect($gym->clients->first())->toBeInstanceOf(Client::class);
});

test('gym has many memberships', function () {
    $gym = Gym::factory()->create();
    $memberships = Membership::factory(2)->create([
        'gym_id' => $gym->id,
    ]);

    expect($gym->memberships->first())->toBeInstanceOf(Membership::class);
});

test('gym has many subscriptions', function () {
    $gym = Gym::factory()->create();
    $subscriptions = Subscription::factory(2)->create([
        'gym_id' => $gym->id,
    ]);

    expect($gym->subscriptions->first())->toBeInstanceOf(Subscription::class);
});

test('gym can check if a user is the owner', function () {
    $user = User::factory()->create();
    $gym = Gym::factory()->create([
        'owner_id' => $user->id,
    ]);

    expect($gym->isOwnedBy($user))->toBeTrue();
});
