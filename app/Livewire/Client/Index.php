<?php

namespace App\Livewire\Client;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $perPage = 15;
    public $currentGym;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
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
            ->where('gym_id', $this->currentGym->id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('ci', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.client.index', [
            'clients' => $clients,
            'currentGym' => $this->currentGym
        ]);
    }
}
