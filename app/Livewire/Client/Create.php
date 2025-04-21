<?php

namespace App\Livewire\Client;

use App\Models\Client;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class Create extends Component
{
    public $name = '';
    public $ci = '';
    public $phone = '';
    public $email = '';
    public $avatar = null;
    public $currentGym;

    protected $rules = [
        'name' => 'required|min:3',
        'ci' => 'required|min:6|unique:clients,ci',
        'phone' => 'required|min:7|unique:clients,phone',
        'email' => 'nullable|email|unique:clients,email',
        'avatar' => 'nullable|image|max:1024', // Máximo 1MB
    ];

    protected $messages = [
        'name.required' => 'El nombre es obligatorio',
        'name.min' => 'El nombre debe tener al menos 3 caracteres',
        'ci.required' => 'El CI es obligatorio',
        'ci.min' => 'El CI debe tener al menos 6 caracteres',
        'ci.unique' => 'Este CI ya está registrado',
        'phone.required' => 'El teléfono es obligatorio',
        'phone.min' => 'El teléfono debe tener al menos 7 caracteres',
        'phone.unique' => 'Este teléfono ya está registrado',
        'email.email' => 'El email debe ser válido',
        'email.unique' => 'Este email ya está registrado',
        'avatar.image' => 'El archivo debe ser una imagen',
        'avatar.max' => 'La imagen no debe superar 1MB',
    ];

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

        // Si se subió una imagen, guardarla
        if ($this->avatar) {
            $path = $this->avatar->store('avatars', 'public');
            $clientData['avatar'] = $path;
        }

        // Crear el cliente
        Client::create($clientData);

        session()->flash('notify', [
            'title' => 'Cliente creado',
            'message' => 'El cliente se ha creado correctamente',
            'type' => 'success',
        ]);

        // Redirigir a la lista de clientes
        return redirect()->route('clients.index');
    }

    public function render()
    {
        return view('livewire.client.create');
    }
} 