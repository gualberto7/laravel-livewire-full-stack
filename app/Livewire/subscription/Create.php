<?php

namespace App\Livewire\Subscription;

use Flux\Flux;
use App\Models\Client;
use Livewire\Component;
use App\Models\Membership;
use Livewire\Attributes\On;
use App\Models\Subscription;
use Illuminate\Support\Carbon;
use Masmerise\Toaster\Toastable;

class Create extends Component
{
    use Toastable;

    public $ci;
    public $client_id;
    public $membership_id;
    public $start_date;
    public $end_date;
    public $selectedClient = null;
    public $memberships = [];
    public $currentGym;

    public $payment_method = 'cash';
    public $payment_status = 'paid';
    public $payment_amount;
    public $payment_notes;

    public function mount()
    {
        $this->currentGym = auth()->user()->getCurrentGym();
        $this->start_date = now()->format('Y-m-d');
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
                $this->client_id = $this->selectedClient->id;
            } else {
                $this->client_id = null;
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
        $this->client_id = $this->selectedClient->id;
    }

    public function deselectClient()
    {
        $this->selectedClient = null;
        $this->client_id = null;
        $this->ci = '';
    }

    public function updatedMembershipId($value)
    {
        if ($value) {
            $membership = Membership::find($value);
            if ($membership) {
                $this->end_date = Carbon::parse($this->start_date)
                    ->addDays($membership->duration)
                    ->format('Y-m-d');

                $this->payment_amount = $membership->price;
            }
        }
    }

    public function updatedStartDate($value)
    {
        if ($this->membership_id) {
            $this->updatedMembershipId($this->membership_id);
        }
    }

    public function save()
    {
        $this->validate([
            'client_id' => 'required|exists:clients,id',
            'membership_id' => 'required|exists:memberships,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $membership = $this->memberships->firstWhere('id', $this->membership_id);

        $subscription = Subscription::create([
            'client_id' => $this->client_id,
            'membership_id' => $this->membership_id,
            'gym_id' => $this->currentGym->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'price' => $membership->price,
            'created_by' => auth()->user()->name,
            'updated_by' => auth()->user()->name,
        ]);

        $subscription->addPayment([
            'amount' => $this->payment_amount,
            'method' => $this->payment_method,
            'status' => $this->payment_status,
            'notes' => $this->payment_notes,
        ]);

        $this->info('Suscripción creada correctamente');

        return $this->redirect(route('subscriptions.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.subscription.create');
    }
}
