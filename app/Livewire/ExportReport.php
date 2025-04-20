<?php

namespace App\Livewire;

use App\Models\GymReport;
use App\Services\GymReportService;
use Livewire\Component;

class ExportReport extends Component
{
    public $reportId;
    public $report;
    public $format = 'pdf';
    
    public function mount($reportId)
    {
        $this->reportId = $reportId;
        $this->report = GymReport::with('gym')->findOrFail($reportId);
    }
    
    public function export(GymReportService $reportService)
    {
        $report = GymReport::findOrFail($this->reportId);
        
        // Aquí implementarías la lógica para exportar el reporte
        // Por ejemplo, usando Laravel Excel o PDF
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Reporte exportado correctamente.',
        ]);
        
        $this->dispatch('closeModal');
    }
    
    public function render()
    {
        return view('livewire.export-report');
    }
} 