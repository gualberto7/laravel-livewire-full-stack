<?php

use App\Models\Membership;
use App\Livewire\Membership\Index;

test('display memberships items', function () {
    $data = createUserGymMembership('gym-owner');

    Livewire::actingAs($data['user'])
        ->test(Index::class)
        ->assertSee($data['membership']->name)
        ->assertHasNoErrors();
});

test('verify the memberships table columns', function () {
    $data = createUserGymMembership('gym-owner');

    Livewire::actingAs($data['user'])
        ->test(Index::class)
        ->assertSee('Nombre')
        ->assertSee('Precio')
        ->assertSee('Duración')
        ->assertSee('Acciones')
        ->assertHasNoErrors();
});

