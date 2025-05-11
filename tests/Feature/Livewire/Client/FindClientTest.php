<?php

use App\Models\Client;
use App\Livewire\Client\Find;

test('verify serach client by ci input', function () {
    $data = createUserGymMembership('gym-owner');
    $client = Client::factory()->create(['gym_id' => $data['gym']->id]);

    Livewire::actingAs($data['user'])
        ->test(Find::class)
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
