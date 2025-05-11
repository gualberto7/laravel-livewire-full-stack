<?php

namespace App\Livewire\Membership;

use Livewire\Component;
use App\Models\Membership;
use App\Traits\HasCurrentGym;

class Index extends Component
{
    use HasCurrentGym;

    public $memberships;

    public function mount()
    {
        $this->initializeCurrentGym();
        $this->memberships = Membership::where('gym_id', $this->currentGym->id)->get();
    }

    public function render()
    {
        return view('livewire.membership.index');
    }
}
