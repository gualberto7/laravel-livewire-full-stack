<?php

namespace App\Livewire;

use App\Models\Gym;
use Livewire\Component;
use Livewire\Attributes\On;

class GymSelector extends Component
{
    public $currentGym;
    public $availableGyms = [];

    public function mount()
    {
        $user = auth()->user();
        $this->currentGym = $user->getCurrentGym();
        $this->availableGyms = $user->allGyms();
    }

    public function selectGym($gymId)
    {
        $gym = Gym::find($gymId);
        
        if ($gym) {
            auth()->user()->setCurrentGym($gym);
            $this->currentGym = $gym;
            
            // Emitir evento para que otros componentes sepan que cambió el gimnasio
            $this->dispatch('gym-changed', gymId: $gym->id)->to('subscriptions');
            
            // Mostrar notificación de éxito
            $this->dispatch('notify', [
                'title' => 'Gimnasio actualizado',
                'message' => "Has cambiado al gimnasio: {$gym->name}",
                'type' => 'success',
            ]);
        }
    }

    #[On('gym-changed')]
    public function updateCurrentGym($gymId)
    {
        $this->currentGym = Gym::find($gymId);
    }

    public function render()
    {
        return view('livewire.gym-selector');
    }
}
