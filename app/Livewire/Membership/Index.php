<?php

namespace App\Livewire\Membership;

use Livewire\Component;
use App\Traits\HasCurrentGym;

class Index extends Component
{
    use HasCurrentGym;

    public $memberships;

    public function mount()
    {
        $this->initializeCurrentGym();
        $this->memberships = $this->currentGym->memberships()->orderBy('price')->get();
    }

    public function render()
    {
        return view('livewire.membership.index');
    }
}
