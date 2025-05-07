<?php

namespace App\Livewire;

use App\Models\Membership;
use Livewire\Component;
use Livewire\Attributes\Rule;

class MembershipForm extends Component
{
    #[Rule('required|string|max:255')]
    public $name = '';

    #[Rule('required|string|max:255')]
    public $price = '';

    #[Rule('required|integer|min:1')]
    public $duration = 30;

    #[Rule('nullable|integer|min:1')]
    public $max_checkins = null;

    #[Rule('nullable|string|max:1000')]
    public $description = '';

    #[Rule('boolean')]
    public $is_promo = false;

    #[Rule('nullable|date|required_if:is_promo,true')]
    public $promo_start_date = null;

    #[Rule('nullable|date|required_if:is_promo,true|after_or_equal:promo_start_date')]
    public $promo_end_date = null;

    public $currentGym;

    public function mount()
    {
        $this->currentGym = auth()->user()->getCurrentGym();
    }

    public function save()
    {
        $this->validate();

        $membership = new Membership([
            'name' => $this->name,
            'price' => $this->price,
            'duration' => $this->duration,
            'max_checkins' => $this->max_checkins,
            'description' => $this->description,
            'is_promo' => $this->is_promo,
            'promo_start_date' => $this->is_promo ? $this->promo_start_date : null,
            'promo_end_date' => $this->is_promo ? $this->promo_end_date : null,
            'created_by' => auth()->user()->name,
            'updated_by' => auth()->user()->name,
            'gym_id' => $this->currentGym->id,
        ]);

        $membership->save();

        $this->dispatch('notify', [
            'message' => 'Membresía creada exitosamente',
            'type' => 'success',
        ]);

        $this->redirect(route('memberships.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.membership-form');
    }
} 