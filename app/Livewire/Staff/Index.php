<?php

namespace App\Livewire\Staff;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public $staff;
    private $currentGym;

    public function mount()
    {
        $this->currentGym = auth()->user()->getCurrentGym();
        $this->staff = $this->currentGym->users;
    }

    public function render()
    {
        return view('livewire.staff.index');
    }
}
