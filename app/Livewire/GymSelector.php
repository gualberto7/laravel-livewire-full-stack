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
            
            // Mostrar notificación de éxito y redireccionar
            session()->flash('notify', [
                'title' => 'Gimnasio actualizado',
                'message' => "Has cambiado al gimnasio: {$gym->name}",
                'type' => 'success',
            ]);
            
            // Redireccionar al dashboard para recargar todos los datos
            return $this->redirect(route('dashboard'), navigate: true);
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
