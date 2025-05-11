<?php

use App\Models\Client;
use App\Models\Subscription;
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
        ->set('form.client_id', $client->id)
        ->set('form.membership_id', $data['membership']->id)
        ->set('form.start_date', now()->addDays(1))
        ->set('form.end_date', now()->addDays(30))
        ->call('save')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('subscriptions', [
        'client_id' => $client->id,
        'membership_id' => $data['membership']->id,
        'gym_id' => $data['gym']->id,
    ]);
});

test('verify create subscription with payment', function () {
    $data = createUserGymMembership('gym-owner');
    $client = Client::factory()->create(['gym_id' => $data['gym']->id]);

    Livewire::actingAs($data['user'])
        ->test(Create::class)
        ->set('form.client_id', $client->id)
        ->set('form.membership_id', $data['membership']->id)
        ->set('form.start_date', now()->addDays(1))
        ->set('form.end_date', now()->addDays(30))
        ->call('save')
        ->assertHasNoErrors();

    $subscription = Subscription::where('client_id', $client->id)->first();

    $this->assertDatabaseHas('payments', [
        'payable_id' => $subscription->id,
        'payable_type' => Subscription::class,
    ]);
});
