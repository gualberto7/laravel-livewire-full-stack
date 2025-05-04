<?php

use App\Livewire\Subscription\Index;
use Livewire\Livewire;

test('display subscriptions items', function () {
    $data = createUserGymMembershipAndSubscription('gym-owner');

    $response = Livewire::actingAs($data['user'])
        ->test(Index::class)
        ->assertSee($data['subscription']->name)
        ->assertSee($data['membership']->name);

    expect($response->assertHasNoErrors());
});

test('verfy the subscriptions table columns', function () {
    $data = createUserGymMembershipAndSubscription('gym-owner');

    $response = Livewire::actingAs($data['user'])
        ->test(Index::class)
        ->assertSee('Cliente')
        ->assertSee('Membresía')
        ->assertSee('Fecha')
        ->assertSee('Estado')
        ->assertSee('Acciones');

    expect($response->assertHasNoErrors());
});
