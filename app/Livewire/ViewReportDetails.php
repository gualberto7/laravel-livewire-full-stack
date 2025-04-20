<?php

namespace App\Livewire;

use App\Models\GymReport;
use Livewire\Component;

class ViewReportDetails extends Component
{
    public $reportId;
    public $report;
    
    public function mount($reportId)
    {
        $this->reportId = $reportId;
        $this->report = GymReport::with('gym')->findOrFail($reportId);
    }
    
    public function render()
    {
        return view('livewire.view-report-details');
    }
} 