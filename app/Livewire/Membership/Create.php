<?php

namespace App\Livewire\Membership;

use Livewire\Component;
use App\Models\Membership;
use Livewire\Attributes\Rule;
use App\Traits\HasCurrentGym;
use Masmerise\Toaster\Toastable;
use App\Livewire\Forms\MembershipForm;

class Create extends Component
{
    use Toastable, HasCurrentGym;

    public MembershipForm $form;

    public function mount()
    {
        $this->initializeCurrentGym();
    }

    public function save()
    {
        $this->form->store($this->currentGym->id);

        $this->info('Membresía creada exitosamente');

        $this->redirect(route('memberships.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.membership.create');
    }
} 