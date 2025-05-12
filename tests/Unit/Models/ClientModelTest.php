<?php

namespace Tests\Unit\Models;

use App\Models\Gym;
use App\Models\Client;
use App\Models\CheckIn;
use App\Models\Subscription;
use App\Models\SubscriptionHistory;

test('client has many subscriptions', function () {
    $client = Client::factory()->create();
    $subscription = Subscription::factory()->create();
    $client->subscriptions()->attach($subscription);
    expect($client->subscriptions->first())->toBeInstanceOf(Subscription::class);
});

test('client belongs to a gym', function () {
    $client = Client::factory()->create();
    expect($client->gym)->toBeInstanceOf(Gym::class);
});

test('client has many check ins', function () {
    $client = Client::factory()->create();
    $checkIn = CheckIn::factory()->create([
        'client_id' => $client->id,
    ]);
    expect($client->checkIns->first())->toBeInstanceOf(CheckIn::class);
});

test('client has many subscription histories', function () {
    $client = Client::factory()->create();
    $subscriptionHistory = SubscriptionHistory::factory()->create([
        'client_id' => $client->id,
    ]);
    expect($client->subscriptionHistories->first())->toBeInstanceOf(SubscriptionHistory::class);
});

test('client has checked in today', function () {
    $client = Client::factory()->create();
    $checkInToday = CheckIn::factory()->create([
        'client_id' => $client->id,
        'created_at' => now(),
    ]);
    $checkInYesterday = CheckIn::factory()->create([
        'client_id' => $client->id,
        'created_at' => now()->subDay(),
    ]);
    expect($client->hasCheckedInToday($checkInToday->gym_id))->toBeTrue();
    expect($client->hasCheckedInToday($checkInYesterday->gym_id))->toBeFalse();
});

test('client can check in', function () {
    $client = Client::factory()->create();
    $checkIn = $client->checkIn($client->gym_id, 'John Doe');
    expect($checkIn)->toBeInstanceOf(CheckIn::class);
});
