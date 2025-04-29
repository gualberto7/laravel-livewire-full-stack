<?php

namespace App\Livewire;

use App\Models\CheckIn;
use Livewire\Component;
use Livewire\WithPagination;

class CheckIns extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 15;
    public $currentGym;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
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
        $checkIns = CheckIn::query()
            ->with(['client', 'gym'])
            ->where('gym_id', $this->currentGym->id)
            ->when($this->search, function ($query) {
                $query->whereHas('client', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('ci', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.check-ins', [
            'checkIns' => $checkIns
        ]);
    }
} 