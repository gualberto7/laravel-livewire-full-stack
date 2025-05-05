<?php

use App\Livewire\Client\Index;
use App\Models\Client;
use Livewire\Livewire;

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

