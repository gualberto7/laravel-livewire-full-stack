<?php

namespace App\Livewire\Staff;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $staff;
    private $currentGym;
    public $canManageStaff = false;

    public function mount()
    {
        $this->currentGym = auth()->user()->getCurrentGym();
        $this->staff = $this->currentGym->users;
        
        // Verificar si el usuario tiene permiso para gestionar el personal
        $this->canManageStaff = Auth::user()->hasRole('super-admin') || 
                               Auth::user()->hasRole('gym-owner') || 
                               Auth::user()->hasPermissionTo('manage gym staff');
    }

    public function deleteStaff($staffId)
    {
        // Verificar si el usuario tiene permiso para eliminar personal
        if (!$this->canManageStaff) {
            $this->dispatch('notify', [
                'message' => 'No tienes permiso para eliminar personal.',
                'type' => 'error'
            ]);
            return;
        }

        $staffMember = User::find($staffId);
        
        if ($staffMember) {
            // Verificar que el personal pertenece al gimnasio actual
            if ($this->currentGym->users->contains($staffMember)) {
                // Eliminar la relación con el gimnasio
                $this->currentGym->users()->detach($staffMember->id);
                
                $this->dispatch('notify', [
                    'message' => 'Personal eliminado correctamente.',
                    'type' => 'success'
                ]);
                
                // Actualizar la lista de personal
                $this->staff = $this->currentGym->users;
            }
        }
    }

    public function render()
    {
        return view('livewire.staff.index');
    }
}
