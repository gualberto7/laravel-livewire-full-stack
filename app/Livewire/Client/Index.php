<?php

namespace App\Livewire\Client;

use Livewire\Component;

class Index extends Component
{
    public $clients;
    private $currentGym;

    public function mount()
    {
        $this->currentGym = auth()->user()->getCurrentGym();
        $this->clients = $this->currentGym->clients;
    }

    public function render()
    {
        return view('livewire.client.index');
    }
}
