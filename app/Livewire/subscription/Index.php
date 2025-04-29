<?php

namespace App\Livewire\Subscription;

use App\Models\Subscription;
use App\Models\Gym;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Client;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'start_date';
    public $sortDirection = 'desc';
    public $perPage = 15;
    public $currentGym;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'start_date'],
        'sortDirection' => ['except' => 'desc'],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        // Obtener el gimnasio actual del usuario autenticado
        $this->currentGym = auth()->user()->getCurrentGym();
    }

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

    public function registerCheckIn($clientId)
    {
        $client = Client::find($clientId);
        $client->checkIn($this->currentGym->id, auth()->user()->name);
    }
    
    public function render()
    {
        // Si no hay gimnasio actual, mostrar un mensaje
        if (!$this->currentGym) {
            return view('livewire.subscription.index', [
                'subscriptions' => collect([]),
                'currentGym' => null
            ]);
        }

        $subscriptions = Subscription::query()
            ->with(['client', 'membership'])
            ->where('gym_id', $this->currentGym->id)
            ->when($this->search, function ($query) {
                $query->whereHas('client', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('membership', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.subscription.index', [
            'subscriptions' => $subscriptions,
            'currentGym' => $this->currentGym
        ]);
    }
}
