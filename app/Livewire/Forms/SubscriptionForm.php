<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Client;
use App\Models\Subscription;
use Livewire\Attributes\Validate;

class SubscriptionForm extends Form
{
    #[Validate('required', 'cliente')]
    public $client_id;

    #[Validate('required', 'membresía')]
    public $membership_id;

    #[Validate('required|date', 'fecha de inicio')]
    public $start_date;

    #[Validate('required|date|after:start_date', 'fecha de fin')]
    public $end_date;

    #[Validate('required|numeric|min:0', 'monto')]
    public $payment_amount;

    public function store($gymId, $membershipPrice)
    {
        $this->validate();

        $subscription = Subscription::create([
            'client_id' => $this->client_id,
            'membership_id' => $this->membership_id,
            'gym_id' => $gymId,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'price' => $membershipPrice,
            'created_by' => auth()->user()->name,
            'updated_by' => auth()->user()->name,
        ]);

        return $subscription;
    }
}
