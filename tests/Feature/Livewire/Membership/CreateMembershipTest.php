<?php

use App\Livewire\Membership\Create;

test('verify create membership component', function () {
    $data = createUserGymMembership('gym-owner');

    Livewire::actingAs($data['user'])
        ->test(Create::class)
        ->assertSee('Nombre')
        ->assertSee('Precio')
        ->assertSee('Duración')
        ->assertSee('Entradas máximas')
        ->assertSee('Descripción')
        ->assertSee('Es una promoción')
        ->assertSee('Crear membresía');
});

test('verify create membership successfully', function () {
    $data = createUserGymMembership('gym-owner');

    Livewire::actingAs($data['user'])
        ->test(Create::class)
        ->set('form.name', 'Membresía de prueba')
        ->set('form.price', 100)
        ->set('form.duration', 30)
        ->call('save');

    $this->assertDatabaseHas('memberships', [
        'name' => 'Membresía de prueba',
        'price' => 100,
        'duration' => 30,
    ]);
});
