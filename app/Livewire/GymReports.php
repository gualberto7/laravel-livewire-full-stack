<?php

namespace App\Livewire;

use App\Models\Gym;
use App\Models\GymReport;
use App\Services\GymReportService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class GymReports extends Component
{
    use WithPagination;

    public $reportType = 'monthly';
    public $selectedYear;
    public $selectedMonth;
    public $gymId;
    
    public function mount()
    {
        $this->selectedYear = Carbon::now()->year;
        $this->selectedMonth = Carbon::now()->month;
        
        // Si el usuario tiene un gimnasio actual, usarlo
        $currentGym = Auth::user()->getCurrentGym();
        if ($currentGym) {
            $this->gymId = $currentGym->id;
        }
    }
    
    public function updatedReportType()
    {
        $this->resetPage();
    }
    
    public function updatedSelectedYear()
    {
        $this->resetPage();
    }
    
    public function updatedSelectedMonth()
    {
        $this->resetPage();
    }
    
    public function updatedGymId()
    {
        $this->resetPage();
    }
    
    #[Computed]
    public function years()
    {
        $firstReport = GymReport::orderBy('year')->first();
        $currentYear = Carbon::now()->year;
        
        if (!$firstReport) {
            return range($currentYear - 2, $currentYear);
        }
        
        return range($firstReport->year, $currentYear);
    }
    
    #[Computed]
    public function months()
    {
        return [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];
    }
    
    #[Computed]
    public function gyms()
    {
        $user = Auth::user();
        
        if ($user->hasRole('super-admin')) {
            return Gym::orderBy('name')->get();
        }
        
        return $user->ownedGyms();
    }
    
    public function generateReports(GymReportService $reportService)
    {
        $gym = Gym::findOrFail($this->gymId);
        
        if ($this->reportType === 'monthly') {
            $reportService->generateMonthlyReport($gym, $this->selectedYear, $this->selectedMonth);
        } else {
            $reportService->generateYearlyReport($gym, $this->selectedYear);
        }
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Reporte generado correctamente.',
        ]);
    }
    
    public function render()
    {
        $query = GymReport::query()
            ->when($this->gymId, function ($query) {
                return $query->where('gym_id', $this->gymId);
            })
            ->when($this->reportType, function ($query) {
                return $query->where('report_type', $this->reportType);
            })
            ->when($this->selectedYear, function ($query) {
                return $query->where('year', $this->selectedYear);
            })
            ->when($this->reportType === 'monthly' && $this->selectedMonth, function ($query) {
                return $query->where('month', $this->selectedMonth);
            })
            ->with('gym')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc');
        
        $reports = $query->paginate(10);
        
        return view('livewire.gym-reports', [
            'reports' => $reports,
        ]);
    }
} 