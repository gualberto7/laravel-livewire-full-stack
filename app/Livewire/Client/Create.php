<?php

namespace App\Livewire\Client;

use Flux\Flux;
use App\Models\Client;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;

class Create extends Component
{
    use Toastable;

    #[Validate('required|min:3', 'nombre')]
    public $name = '';

    #[Validate('required|min:6', 'carnet')]
    public $ci = '';

    #[Validate('required|min:7', 'celular')]
    public $phone = '';

    #[Validate('nullable|email', 'correo')]
    public $email = '';

    public $currentGym;
    public $fromModal = false;

    public function mount()
    {
        $this->currentGym = auth()->user()->getCurrentGym();
    }

    public function boot()
    {
        $this->withValidator(function ($validator) {
            $validator->after(function ($validator) {
                if (Client::where('ci', $this->ci)
                    ->where('gym_id', $this->currentGym->id)
                    ->exists()) {
                    $validator->errors()->add('ci', 'Este nro. de carnet ya está registrado en este gimnasio.');
                }
            });
        });
    }

    public function save()
    {
        $this->validate();

        $clientData = [
            'name' => $this->name,
            'ci' => $this->ci,
            'phone' => $this->phone,
            'email' => $this->email,
            'gym_id' => $this->currentGym->id,
        ];

        $client = Client::create($clientData);

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