<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Membership;

class Memberships extends Component
{
    public $currentGym;
    public $memberships;

    public function mount()
    {
        $this->currentGym = auth()->user()->getCurrentGym();
        $this->memberships = Membership::where('gym_id', $this->currentGym->id)->get();
    }

    public function render()
    {
        return view('livewire.memberships');
    }
}
