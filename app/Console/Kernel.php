<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * These schedules are run in a default, single-server configuration.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        // ... existing code ...
        
        // Generar reportes mensuales el primer día de cada mes
        $schedule->command('gym:generate-reports --month=' . now()->subMonth()->month . ' --year=' . now()->subMonth()->year)
            ->monthly()
            ->onOneServer();
        
        // Generar reportes anuales el primer día de cada año
        $schedule->command('gym:generate-reports --year=' . now()->subYear()->year)
            ->yearly()
            ->onOneServer();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
} 