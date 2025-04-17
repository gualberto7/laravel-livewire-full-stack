<?php

namespace App\Livewire\Staff;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Show extends Component
{
    public ?User $staffMember = null;
    public $currentGym;
    public $canManageStaff = false;

    public function mount($staffMember)
    {
        $this->staffMember = $staffMember;
        $this->currentGym = auth()->user()->getCurrentGym();
        
        // Verificar si el usuario tiene permiso para gestionar el personal
        $this->canManageStaff = Auth::user()->hasRole('super-admin') || 
                               Auth::user()->hasRole('gym-owner') || 
                               Auth::user()->hasPermissionTo('manage gym staff');
    }

    public function render()
    {
        $role = $this->staffMember->getRoleInGym($this->currentGym);
        $permissions = $this->staffMember->getAllPermissions()->pluck('name');
        $roles = $this->staffMember->getRoleNames();

        return view('livewire.staff.show', [
            'role' => $role,
            'permissions' => $permissions,
            'roles' => $roles,
        ]);
    }
}
