<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Membership;
use Livewire\Attributes\Validate;

class MembershipForm extends Form
{
    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|numeric|min:0')]
    public $price = '';

    #[Validate('required|integer|min:1')]
    public $duration = 30;

    #[Validate('nullable|integer|min:1')]
    public $max_checkins = null;

    #[Validate('nullable|string|max:1000')]
    public $description = '';

    #[Validate('boolean')]
    public $is_promo = false;

    #[Validate('nullable|date|required_if:is_promo,true')]
    public $promo_start_date = null;

    #[Validate('nullable|date|required_if:is_promo,true|after_or_equal:promo_start_date')]
    public $promo_end_date = null;

    #[Validate('nullable|integer|min:0')]
    public $max_clients = 1;

    #[Validate('nullable|integer|min:1')]
    public $max_installments = 1;

    public function setMembership(Membership $membership)
    {
        $this->name = $membership->name;
        $this->price = $membership->price;
        $this->duration = $membership->duration;
        $this->max_checkins = $membership->max_checkins;
        $this->description = $membership->description;
        $this->is_promo = $membership->is_promo;
        $this->promo_start_date = $membership->promo_start_date;
        $this->promo_end_date = $membership->promo_end_date;
        $this->max_clients = $membership->max_clients;
        $this->max_installments = $membership->max_installments;
    }

    public function store($gymId)
    {
        $this->validate();

        Membership::create($this->all() + [
            'gym_id' => $gymId,
            'created_by' => auth()->user()->name,
            'updated_by' => auth()->user()->name,
        ]);
    }

    public function update(Membership $membership)
    {
        $this->validate();

        $membership->update($this->all() + [
            'updated_by' => auth()->user()->name,
        ]);
    }
}
