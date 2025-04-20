<?php

namespace App\Console\Commands;

use App\Models\Gym;
use App\Services\GymReportService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateGymReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gym:generate-reports {--gym= : ID del gimnasio específico} {--month= : Mes específico (1-12)} {--year= : Año específico}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera reportes de ingresos para los gimnasios';

    /**
     * Execute the console command.
     */
    public function handle(GymReportService $reportService)
    {
        $gymId = $this->option('gym');
        $month = $this->option('month');
        $year = $this->option('year') ?: Carbon::now()->year;
        
        $query = Gym::query();
        
        if ($gymId) {
            $query->where('id', $gymId);
        }
        
        $gyms = $query->get();
        
        if ($gyms->isEmpty()) {
            $this->error('No se encontraron gimnasios.');
            return 1;
        }
        
        $this->info('Generando reportes para ' . $gyms->count() . ' gimnasio(s)...');
        
        $bar = $this->output->createProgressBar($gyms->count());
        $bar->start();
        
        foreach ($gyms as $gym) {
            if ($month) {
                // Generar reporte para un mes específico
                $reportService->generateMonthlyReport($gym, $year, $month);
            } else {
                // Generar todos los reportes pendientes
                $reportService->generatePendingReports($gym);
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        $this->info('Reportes generados correctamente.');
        
        return 0;
    }
} 