<?php

namespace App\Livewire\Forms;

use Livewire\Form;
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

    public $payment_method = 'cash';
    public $payment_status = 'paid';
    public $payment_amount;
    public $payment_notes;
    
    public function store($gymId, $membership)
    {
        $this->validate();

        $subscription = Subscription::create($this->all() + [
            'gym_id' => $gymId,
            'price' => $membership->price,
            'created_by' => auth()->user()->name,
            'updated_by' => auth()->user()->name,
        ]);

        $subscription->addPayment([
            'amount' => $this->payment_amount,
            'method' => $this->payment_method,
            'status' => $this->payment_status,
            'notes' => $this->payment_notes,
        ]);

        return $subscription;
    }
}
