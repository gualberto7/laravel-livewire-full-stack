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

    public function store($gymId)
    {
        $this->validate();

        Membership::create($this->all() + [
            'gym_id' => $gymId,
            'created_by' => auth()->user()->name,
            'updated_by' => auth()->user()->name,
        ]);
    }
}
