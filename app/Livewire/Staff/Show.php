<?php

namespace App\Livewire\Staff;

use App\Models\User;
use Livewire\Component;

class Show extends Component
{
    public ?User $staffMember = null;
    public $currentGym;

    public function mount($staffMember)
    {
        $this->staffMember = $staffMember;
        $this->currentGym = auth()->user()->getCurrentGym();
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
