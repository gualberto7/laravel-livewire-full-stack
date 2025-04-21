<?php

namespace App\Livewire\Client;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public Client $client;
    public $name;
    public $ci;
    public $phone;
    public $email;
    public $profile_photo;
    public $profile_photo_path;

    public function mount($client)
    {
        $this->client = $client;
        $this->name = $client->name;
        $this->ci = $client->ci;
        $this->phone = $client->phone;
        $this->email = $client->email;
        $this->profile_photo_path = $client->profile_photo_path;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'ci' => 'required|string|max:20|unique:clients,ci,' . $this->client->id,
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'profile_photo' => 'nullable|image|max:1024',
        ]);

        if ($this->profile_photo) {
            $this->profile_photo_path = $this->profile_photo->store('profile-photos', 'public');
        }

        $this->client->update([
            'name' => $this->name,
            'ci' => $this->ci,
            'phone' => $this->phone,
            'email' => $this->email,
            'profile_photo_path' => $this->profile_photo_path ?? $this->client->profile_photo_path,
        ]);

        session()->flash('message', 'Cliente actualizado correctamente.');

        return redirect()->route('clients.index');
    }

    public function render()
    {
        return view('livewire.client.edit');
    }
} 