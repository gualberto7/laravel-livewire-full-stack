<?php

namespace App\Livewire\Client;

use Flux\Flux;
use App\Models\Client;
use Livewire\Component;
use App\Traits\HasCurrentGym;

class Find extends Component
{
    use HasCurrentGym;

    public $ci = '';
    public $selectedClient = null;
    public $fromModal = false;

    public function mount($fromModal = false)
    {
        $this->initializeCurrentGym();
        $this->fromModal = $fromModal;
    }

    public function searchClient()
    {
        if (strlen($this->ci) >= 6) {
            $this->selectedClient = Client::where('gym_id', $this->currentGym->id)
                ->where('ci', 'like', '%' . $this->ci . '%')
                ->first();

            if ($this->selectedClient) {
                $this->dispatch('client-selected', client: $this->selectedClient);
            }
        }
    }

    public function openModal()
    {
        Flux::modal('create-client')->show();
    }

    public function createdClient()
    {
        $this->selectedClient = Client::where('ci', $this->ci)->first();
        $this->dispatch('client-selected', client: $this->selectedClient);
    }

    public function deselectClient()
    {
        $this->selectedClient = null;
        $this->ci = '';
        $this->dispatch('client-deselected');
    }

    public function render()
    {
        return view('livewire.client.find');
    }
}
