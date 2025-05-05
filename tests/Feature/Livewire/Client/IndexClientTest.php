<?php

use App\Models\Client;
use App\Models\Subscription;
use App\Livewire\Client\Index;

test('display clients items', function () {
    $data = createUserGymMembershipAndSubscription('gym-owner');

    $response = Livewire::actingAs($data['user'])
        ->test(Index::class)
        ->assertSee($data['client']->name);

    expect($response->assertHasNoErrors());
});

test('verify the clients table columns', function () {
    $data = createUserGymMembershipAndSubscription('gym-owner');

    $response = Livewire::actingAs($data['user'])
        ->test(Index::class)
        ->assertSee('Nombre')
        ->assertSee('Carnet')
        ->assertSee('Teléfono')
        ->assertSee('Estado')
        ->assertSee('Acciones');

    expect($response->assertHasNoErrors());
});

test('verify search client by name', function () {
    $data = createUserGymMembershipAndSubscription('gym-owner');

    $response = Livewire::actingAs($data['user'])
        ->test(Index::class)
        ->set('search', 'NoClient')
        ->assertDontSee($data['client']->name)
        ->assertSee('No se encontraron clientes.')
        ->set('search', $data['client']->name)
        ->assertSee($data['client']->name);

    expect($response->assertHasNoErrors());
});

test('verify search client by ci', function () {
    $data = createUserGymMembershipAndSubscription('gym-owner');

    $response = Livewire::actingAs($data['user'])
        ->test(Index::class)
        ->set('search', 'NoClient')
        ->assertDontSee($data['client']->name)
        ->assertSee('No se encontraron clientes.')
        ->set('search', $data['client']->ci)
        ->assertSee($data['client']->name);

    expect($response->assertHasNoErrors());
});

test('verify active / expired filters', function () {
    $data = createUserGymMembershipAndSubscription('gym-owner');
    $client = Client::factory()->create([
        'gym_id' => $data['gym']->id,
    ]);
    Client::factory(5)->create([
        'gym_id' => $data['gym']->id,
    ]);

    // Create an active subscription for the client
    Subscription::factory()->create([
        'gym_id' => $data['gym']->id,
        'membership_id' => $data['membership']->id,
        'client_id' => $client->id,
        'start_date' => now(),
        'end_date' => now()->addDays(30),
    ]);

    // Create an expired subscription for the client
    Subscription::factory()->create([
        'gym_id' => $data['gym']->id,
        'membership_id' => $data['membership']->id,
        'client_id' => $client->id,
        'start_date' => now()->subDays(30),
        'end_date' => now()->subDays(1),
    ]);

    $response = Livewire::actingAs($data['user'])
        ->test(Index::class)
        ->assertViewHas('clients', function ($clients) {
            return $clients->count() === 7;
        })
        ->call('filterByStatus', 'active')
        ->assertViewHas('clients', function ($clients) {
            return $clients->count() === 2;
        })
        ->call('filterByStatus', 'expired')
        ->assertViewHas('clients', function ($clients) {
            return $clients->count() === 1;
        });

    expect($response->assertHasNoErrors());
});
