<?php

namespace App\Livewire;

use App\Models\CheckIn;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class CheckIns extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 15;
    public $currentGym;
    public $selectedDay;
    public $daysOfWeek = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'page' => ['except' => 1],
        'perPage' => ['except' => 15],
        'selectedDay' => ['except' => 'today'],
    ];

    public function mount()
    {
        $this->currentGym = auth()->user()->getCurrentGym();
        $this->selectedDay = 'today';
        $this->daysOfWeek = $this->getDaysOfWeek();
    }

    public function getDaysOfWeek()
    {
        $today = Carbon::today();
        $days = [];

        $days['today'] = 'Hoy'. ' - ' . $today->format('d/m');

        for ($i = 1; $i <= 6; $i++) {
            $date = $today->copy()->subDays($i);
            $dayName = $date->locale('es')->dayName;
            $days[$date->format('Y-m-d')] = ucfirst($dayName) . ' - ' . $date->format('d/m');
        }

        return $days;
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

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function updatingSelectedDay()
    {
        $this->resetPage();
    }

    public function render()
    {
        $checkIns = CheckIn::query()
            ->with(['client', 'gym'])
            ->where('gym_id', $this->currentGym->id)
            ->when($this->selectedDay === 'today', function ($query) {
                $query->whereDate('created_at', today());
            }, function ($query) {
                $query->whereDate('created_at', $this->selectedDay);
            })
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