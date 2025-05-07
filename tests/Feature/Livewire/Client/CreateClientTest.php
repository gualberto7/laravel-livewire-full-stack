<?php

use App\Models\Client;
use App\Livewire\Client\Create;

test('verify create client component', function () {
    $data = createUserGymMembership('gym-owner');

    Livewire::actingAs($data['user'])
        ->test(Create::class)
        ->assertSee('Nombre')
        ->assertSee('Carnet de identidad')
        ->assertSee('Celular')
        ->assertSee('Correo electrónico')
        ->assertSee('Crear cliente');
});

test('verify create client successfully', function () {
    $data = createUserGymMembership('gym-owner');

    Livewire::actingAs($data['user'])
        ->test(Create::class)
        ->set('form.name', 'John Doe')
        ->set('form.ci', '7526375')
        ->set('form.phone', '78669441')
        ->set('form.email', 'john.doe@example.com')
        ->call('save')
        ->assertRedirect(route('clients.index'));

    $this->assertDatabaseHas('clients', [
        'name' => 'John Doe',
        'ci' => '7526375',
        'phone' => '78669441',
        'email' => 'john.doe@example.com',
        'gym_id' => $data['gym']->id,
    ]);
});

test('verify create client with errors', function () {
    $data = createUserGymMembership('gym-owner');

    Livewire::actingAs($data['user'])
        ->test(Create::class)
        ->set('form.name', '')
        ->set('form.ci', '')
        ->set('form.phone', '')
        ->set('form.email', '')
        ->call('save')
        ->assertSee('El campo nombre es obligatorio.')
        ->assertSee('El campo carnet es obligatorio.')
        ->assertSee('El campo celular es obligatorio.')
        ->assertHasErrors();
});

test('verify create client with existing ci', function () {
    $data = createUserGymMembership('gym-owner');
    Client::factory()->create([
        'ci' => '7526375',
        'gym_id' => $data['gym']->id,
    ]);

    Livewire::actingAs($data['user'])
        ->test(Create::class)
        ->set('form.ci', '7526375')
        ->call('save')
        ->assertSee('Este nro. de carnet ya está registrado en este gimnasio.')
        ->assertHasErrors();
});

test('verify redirect to clients index after create client', function () {
    $data = createUserGymMembership('gym-owner');

    $response = Livewire::actingAs($data['user'])
        ->test(Create::class)
        ->set('form.name', 'John Doe')
        ->set('form.ci', '7526375')
        ->set('form.phone', '78669441')
        ->set('form.email', 'john.doe@example.com')
        ->call('save')
        ->assertRedirect(route('clients.index'));
});
