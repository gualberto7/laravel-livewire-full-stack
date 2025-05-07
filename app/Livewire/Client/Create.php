<?php

namespace App\Livewire\Client;

use Flux\Flux;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use App\Livewire\Forms\ClientForm;

class Create extends Component
{
    use Toastable;

    public ClientForm $form;
    public $fromModal = false;
    public $currentGym;

    public function mount()
    {
        $this->currentGym = auth()->user()->getCurrentGym();
    }

    public function save()
    {
        $this->form->store($this->currentGym->id);

        $this->info('Cliente creado correctamente');

        if (!$this->fromModal) {
            return redirect()->route('clients.index');
        } else {
            Flux::modal('create-client')->close();
        }
    }

    public function render()
    {
        return view('livewire.client.create');
    }
} 