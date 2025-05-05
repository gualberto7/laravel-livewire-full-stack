<?php

use App\Models\Subscription;
use App\Livewire\Subscription\Index;

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

test('verify search subscription by client name', function () {
    $data = createUserGymMembershipAndSubscription('gym-owner');
    Subscription::factory(2)->create([
        'gym_id' => $data['gym']->id,
        'membership_id' => $data['membership']->id,
    ]);

    $response = Livewire::actingAs($data['user'])
        ->test(Index::class)
        ->set('search', 'NoClient')
        ->assertDontSee('Client Test')
        ->assertSee('No se encontraron suscripciones.')
        ->set('search', 'Client Test')
        ->assertSee('Client Test');

    expect($response->assertHasNoErrors());
});

test('verify pagination per page', function () {
    $data = createUserGymMembershipAndSubscription('gym-owner');

    Subscription::factory(20)->create([
        'gym_id' => $data['gym']->id,
        'membership_id' => $data['membership']->id,
    ]);

    $response = Livewire::actingAs($data['user'])
        ->test(Index::class)
        ->assertViewHas('subscriptions', function ($subscriptions) {
            return count($subscriptions) === 15;
        })
        ->set('perPage', 10)
        ->assertViewHas('subscriptions', function ($subscriptions) {
            return count($subscriptions) === 10;
        });

    expect($response->assertHasNoErrors());
});

test('verify register check in', function () {
    $data = createUserGymMembershipAndSubscription('gym-owner');

    $response = Livewire::actingAs($data['user'])
        ->test(Index::class)
        ->call('registerCheckIn', $data['client']->id);

    $this->assertDatabaseHas('check_ins', [
        'client_id' => $data['client']->id,
        'gym_id' => $data['gym']->id,
    ]);

    expect($response->assertHasNoErrors());
});
