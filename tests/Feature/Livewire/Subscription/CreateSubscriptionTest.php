<?php

use App\Models\Client;
use App\Livewire\Subscription\Create;

test('verify create subscription component', function () {
    $data = createUserGymMembership('gym-owner');

    Livewire::actingAs($data['user'])
        ->test(Create::class)
        ->assertSee('Buscar cliente por CI')
        ->assertSee('Membresía')
        ->assertSee('Fecha de inicio')
        ->assertSee('Fecha de fin')
        ->assertSee('Crear suscripción');
});

test('verify create subscription successfully', function () {
    $data = createUserGymMembership('gym-owner');
    $client = Client::factory()->create(['gym_id' => $data['gym']->id]);

    Livewire::actingAs($data['user'])
        ->test(Create::class)
        ->set('client_id', $client->id)
        ->set('membership_id', $data['membership']->id)
        ->set('start_date', now()->addDays(1))
        ->set('end_date', now()->addDays(30))
        ->call('save')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('subscriptions', [
        'client_id' => $client->id,
        'membership_id' => $data['membership']->id,
        'gym_id' => $data['gym']->id,
    ]);
});

test('verify serach client by ci input', function () {
    $data = createUserGymMembership('gym-owner');
    $client = Client::factory()->create(['gym_id' => $data['gym']->id]);

    Livewire::actingAs($data['user'])
        ->test(Create::class)
        ->set('ci', '94453206')
        ->call('searchClient')
        ->assertSee('No se encontró ningún cliente con CI: 94453206')
        ->assertSee('Crear cliente')
        ->set('ci', $client->ci)
        ->call('searchClient')
        ->assertSee($client->name)
        ->assertSee($client->ci)
        ->assertSee('Deseleccionar');
});
