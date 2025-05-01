<?php

namespace App\Livewire\Client;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Traits\VerifiesGymAccess;

class Edit extends Component
{
    use WithFileUploads, VerifiesGymAccess;

    public Client $client;
    public $name;
    public $ci;
    public $phone;
    public $email;
    public $profile_photo;
    public $avatar;

    public function mount($client)
    {
        $this->verifyGymAccess($client);
        $this->client = $client;
        $this->name = $client->name;
        $this->ci = $client->ci;
        $this->phone = $client->phone;
        $this->email = $client->email;
        $this->avatar = $client->avatar;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'profile_photo' => 'nullable|image|max:1024',
        ]);

        if ($this->profile_photo) {
            $this->avatar = $this->profile_photo->store('profile-photos', 'public');
        }

        $this->client->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'avatar' => $this->avatar ?? $this->client->avatar,
        ]);

        session()->flash('message', 'Cliente actualizado correctamente.');

        return redirect()->route('clients.index');
    }

    public function render()
    {
        return view('livewire.client.edit');
    }
} 