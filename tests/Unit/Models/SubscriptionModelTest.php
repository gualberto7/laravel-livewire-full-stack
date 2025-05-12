<?php

use App\Models\Gym;
use App\Models\Client;
use App\Models\Membership;
use App\Models\Subscription;

test('subscription belongs to many clients', function () {
    $subscription = Subscription::factory()->create();
    $client = Client::factory()->create();
    $subscription->clients()->attach($client);
    expect($subscription->clients->first())->toBeInstanceOf(Client::class);
});

test('subscription belongs to a membership', function () {
    $subscription = Subscription::factory()->create();

    expect($subscription->membership)->toBeInstanceOf(Membership::class);
});

test('subscription belongs to a gym', function () {
    $subscription = Subscription::factory()->create();

    expect($subscription->gym)->toBeInstanceOf(Gym::class);
});

test('subscription return active status', function () {
    $subscription = Subscription::factory()->create([
        'start_date' => now()->subDay(),
        'end_date' => now()->addDay(),
    ]);

    expect($subscription->getStatus())->toBe('activa');
});

test('subscription return pending status', function () {
    $subscription = Subscription::factory()->create([
        'start_date' => now()->addDay(),
        'end_date' => now()->addDays(2),
    ]);

    expect($subscription->getStatus())->toBe('pendiente');
});

test('subscription return expired status', function () {
    $subscription = Subscription::factory()->create([
        'start_date' => now()->subDays(2),
        'end_date' => now()->subDay(),
    ]);

    expect($subscription->getStatus())->toBe('vencida');
});
    