<?php

namespace App\Livewire\Subscription;

use Livewire\Component;
use App\Models\Membership;
use Livewire\Attributes\On;
use App\Traits\HasCurrentGym;
use Illuminate\Support\Carbon;
use Masmerise\Toaster\Toastable;
use App\Livewire\Forms\SubscriptionForm;

class Create extends Component
{
    use Toastable, HasCurrentGym;

    public SubscriptionForm $form;

    public $selectedClient = null;
    public $memberships = [];

    public function mount()
    {
        $this->initializeCurrentGym();
        $this->form->start_date = now()->format('Y-m-d');
        $this->loadMemberships();
    }

    public function loadMemberships()
    {
        if ($this->currentGym) {
            $this->memberships = Membership::where('gym_id', $this->currentGym->id)
                ->orderBy('name')
                ->get();
        }
    }

    #[On('client-selected')]
    public function handleClientSelected($client)
    {
        $this->selectedClient = $client;
        $this->form->client_id = $client['id'];
    }

    #[On('client-deselected')]
    public function handleClientDeselected()
    {
        $this->selectedClient = null;
        $this->form->client_id = null;
    }

    public function updatedFormMembershipId($value)
    {
        if ($value) {
            $membership = Membership::find($value);
            if ($membership) {
                $this->form->end_date = Carbon::parse($this->form->start_date)
                    ->addDays($membership->duration)
                    ->format('Y-m-d');

                $this->form->payment_amount = $membership->price;
            }
        }
    }

    public function updatedFormStartDate($value)
    {
        if ($this->form->membership_id) {
            $this->updatedFormMembershipId($this->form->membership_id);
        }
    }

    public function save()
    {
        $membership = $this->memberships->firstWhere('id', $this->form->membership_id);

        $this->form->store($this->currentGym->id, $membership);

        $this->info('Suscripción creada correctamente');

        return $this->redirect(route('subscriptions.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.subscription.create');
    }
}
