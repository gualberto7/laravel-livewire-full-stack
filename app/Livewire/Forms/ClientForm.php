<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Client;
use App\Rules\UniqueInGym;
use Livewire\Attributes\Validate;

class ClientForm extends Form
{
    #[Validate('required|min:3', 'nombre')]
    public $name = '';

    #[Validate([
        'required',
        'min:6',
        new UniqueInGym
    ], 'carnet')]
    public $ci = '';

    #[Validate('required|min:7', 'celular')]
    public $phone = '';

    #[Validate('nullable|email', 'correo')]
    public $email = '';

    public function store($gymId)
    {
        $this->validate();

        Client::create($this->all() + ['gym_id' => $gymId]);
    }
}
