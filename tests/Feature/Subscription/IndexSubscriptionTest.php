<?php

use App\Models\User;
use App\Livewire\Subscription\Index;

test('subscription index page is displayed', function () {
    $data = createUserGymMembershipAndSubscription('gym-owner');

    $this->actingAs($data['user']);

    $this->get('/subscriptions')->assertOk();
});

test('index component exists on the page', function () {
    $data = createUserGymMembershipAndSubscription('gym-owner');

    $this->actingAs($data['user']);

    $this->get('/subscriptions')->assertSeeLivewire(Index::class);
});
