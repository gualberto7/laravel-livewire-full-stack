<?php

namespace App\Livewire\Subscription;

use Flux\Flux;
use App\Models\Client;
use Livewire\Component;
use App\Models\Membership;
use Livewire\Attributes\On;
use Illuminate\Support\Carbon;
use Masmerise\Toaster\Toastable;
use App\Livewire\Forms\SubscriptionForm;

class Create extends Component
{
    use Toastable;

    public SubscriptionForm $form;

    public $ci;
    public $selectedClient = null;
    public $memberships = [];
    public $currentGym;

    public function mount()
    {
        $this->currentGym = auth()->user()->getCurrentGym();
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

    public function searchClient()
    {
        if (strlen($this->ci) >= 6) {
            $this->selectedClient = Client::where('gym_id', $this->currentGym->id)
                ->where('ci', 'like', '%' . $this->ci . '%')
                ->first();

            if ($this->selectedClient) {
                $this->form->client_id = $this->selectedClient->id;
            } else {
                $this->form->client_id = null;
            }
        }
    }

    public function openModal()
    {
        Flux::modal('create-client')->show();
    }

    public function clientCreated()
    {
        $this->selectedClient = Client::where('ci', $this->ci)->first();
        $this->form->client_id = $this->selectedClient->id;
    }

    public function deselectClient()
    {
        $this->selectedClient = null;
        $this->form->client_id = null;
        $this->ci = '';
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
