<?php

namespace App\Livewire\Client;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\HasCurrentGym;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination, HasCurrentGym;

    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $perPage = 15;
    public $subscriptionStatus = 'all';

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
        'page' => ['except' => 1],
        'subscriptionStatus' => ['except' => 'all'],
    ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function filterByStatus($status)
    {
        $this->subscriptionStatus = $status;
        $this->resetPage();
    }

    public function render()
    {
        // Si no hay gimnasio actual, mostrar un mensaje
        if (!$this->currentGym) {
            return view('livewire.client.index', [
                'clients' => Client::query()->where('id', 0)->paginate($this->perPage),
                'currentGym' => null
            ]);
        }

        $clients = Client::query()
            ->with(['subscriptions' => function ($query) {
                $query->latest()->limit(1);
            }])
            ->where('gym_id', $this->currentGym->id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('ci', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->subscriptionStatus !== 'all', function ($query) {
                $query->whereHas('subscriptions', function ($q) {
                    $now = now();
                    
                    if ($this->subscriptionStatus === 'active') {
                        $q->where('start_date', '<=', $now)
                          ->where('end_date', '>=', $now);
                    } elseif ($this->subscriptionStatus === 'expired') {
                        $q->where('end_date', '<', $now);
                    }
                });
            })
            ->when($this->subscriptionStatus === 'all', function ($query) {
                // No necesitamos filtrar, pero podríamos querer incluir clientes sin suscripción
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.client.index', [
            'clients' => $clients,
            'currentGym' => $this->currentGym
        ]);
    }
}
