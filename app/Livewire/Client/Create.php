<?php

namespace App\Livewire\Client;

use Flux\Flux;
use App\Models\Client;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Illuminate\Support\Facades\Storage;

class Create extends Component
{
    use Toastable;

    public $name = '';
    public $ci = '';
    public $phone = '';
    public $email = '';
    public $avatar = null;
    public $currentGym;
    public $fromModal = false;

    protected $rules = [
        'name' => 'required|min:3',
        'ci' => 'required|min:6',
        'phone' => 'required|min:7',
        'email' => 'nullable|email',
        'avatar' => 'nullable|image|max:1024', // Máximo 1MB
    ];

    protected $messages = [
        'name.required' => 'El nombre es obligatorio',
        'name.min' => 'El nombre debe tener al menos 3 caracteres',
        'ci.required' => 'El CI es obligatorio',
        'ci.min' => 'El CI debe tener al menos 6 caracteres',
        'phone.required' => 'El teléfono es obligatorio',
        'phone.min' => 'El teléfono debe tener al menos 7 caracteres',
        'email.email' => 'El email debe ser válido',
        'avatar.image' => 'El archivo debe ser una imagen',
        'avatar.max' => 'La imagen no debe superar 1MB',
    ];

    public function boot()
    {
        $this->rules['ci'] = [
            'required',
            'min:6',
            function ($attribute, $value, $fail) {
                $exists = Client::where('ci', $value)
                    ->where('gym_id', $this->currentGym->id)
                    ->exists();
                
                if ($exists) {
                    $fail('Este CI ya está registrado en este gimnasio.');
                }
            }
        ];

        $this->rules['email'] = [
            'nullable',
            'email',
            function ($attribute, $value, $fail) {
                if ($value) {
                    $exists = Client::where('email', $value)
                        ->where('gym_id', $this->currentGym->id)
                        ->exists();
                    
                    if ($exists) {
                        $fail('Este email ya está registrado en este gimnasio.');
                    }
                }
            }
        ];
    }

    public function mount()
    {
        $this->currentGym = auth()->user()->getCurrentGym();
    }

    public function updatedAvatar()
    {
        $this->validateOnly('avatar');
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

        if ($this->avatar) {
            $path = $this->avatar->store('avatars', 'public');
            $clientData['avatar'] = $path;
        }

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