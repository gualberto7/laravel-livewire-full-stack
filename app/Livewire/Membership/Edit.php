<?php

namespace App\Livewire\Membership;

use Livewire\Component;
use App\Models\Membership;
use App\Traits\HasCurrentGym;
use Masmerise\Toaster\Toastable;
use App\Livewire\Forms\MembershipForm;

class Edit extends Component
{
    use Toastable, HasCurrentGym;

    public MembershipForm $form;
    public Membership $membership;

    public function mount(Membership $membership)
    {
        $this->initializeCurrentGym();
        $this->membership = $membership;
        $this->form->setMembership($membership);
    }

    public function save()
    {
        $this->form->update($this->membership);

        $this->info('Membresía actualizada exitosamente');

        $this->redirect(route('memberships.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.membership.edit');
    }
} 