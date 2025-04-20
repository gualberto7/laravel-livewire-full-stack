<?php

namespace App\Services;

use App\Models\Gym;
use App\Models\GymReport;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GymReportService
{
    /**
     * Genera el reporte mensual para un gimnasio
     *
     * @param Gym $gym
     * @param int $year
     * @param int $month
     * @return GymReport
     */
    public function generateMonthlyReport(Gym $gym, int $year, int $month): GymReport
    {
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();
        
        // Obtener suscripciones activas al final del mes
        $activeSubscriptions = $gym->subscriptions()
            ->where('start_date', '<=', $endDate)
            ->where(function ($query) use ($endDate) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', $endDate);
            })
            ->count();
        
        // Obtener nuevas suscripciones en el mes
        $newSubscriptions = $gym->subscriptions()
            ->whereBetween('start_date', [$startDate, $endDate])
            ->count();
        
        // Obtener suscripciones que expiraron en el mes
        $expiredSubscriptions = $gym->subscriptions()
            ->whereBetween('end_date', [$startDate, $endDate])
            ->count();
        
        // Calcular ingresos totales del mes
        $totalIncome = $gym->subscriptions()
            ->whereBetween('start_date', [$startDate, $endDate])
            ->join('memberships', 'subscriptions.membership_id', '=', 'memberships.id')
            ->sum('memberships.price');
        
        // Desglose por tipo de membresía
        $membershipBreakdown = $gym->subscriptions()
            ->whereBetween('start_date', [$startDate, $endDate])
            ->join('memberships', 'subscriptions.membership_id', '=', 'memberships.id')
            ->select('memberships.name', DB::raw('COUNT(*) as count'), DB::raw('SUM(memberships.price) as total'))
            ->groupBy('memberships.id', 'memberships.name')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->name => [
                    'count' => $item->count,
                    'total' => $item->total,
                ]];
            })
            ->toArray();
        
        // Crear o actualizar el reporte
        return GymReport::updateOrCreate(
            [
                'gym_id' => $gym->id,
                'report_type' => 'monthly',
                'year' => $year,
                'month' => $month,
            ],
            [
                'total_income' => $totalIncome,
                'active_subscriptions' => $activeSubscriptions,
                'new_subscriptions' => $newSubscriptions,
                'expired_subscriptions' => $expiredSubscriptions,
                'membership_breakdown' => $membershipBreakdown,
            ]
        );
    }
    
    /**
     * Genera el reporte anual para un gimnasio
     *
     * @param Gym $gym
     * @param int $year
     * @return GymReport
     */
    public function generateYearlyReport(Gym $gym, int $year): GymReport
    {
        $startDate = Carbon::createFromDate($year, 1, 1)->startOfYear();
        $endDate = $startDate->copy()->endOfYear();
        
        // Obtener suscripciones activas al final del año
        $activeSubscriptions = $gym->subscriptions()
            ->where('start_date', '<=', $endDate)
            ->where(function ($query) use ($endDate) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', $endDate);
            })
            ->count();
        
        // Obtener nuevas suscripciones en el año
        $newSubscriptions = $gym->subscriptions()
            ->whereBetween('start_date', [$startDate, $endDate])
            ->count();
        
        // Obtener suscripciones que expiraron en el año
        $expiredSubscriptions = $gym->subscriptions()
            ->whereBetween('end_date', [$startDate, $endDate])
            ->count();
        
        // Calcular ingresos totales del año
        $totalIncome = $gym->subscriptions()
            ->whereBetween('start_date', [$startDate, $endDate])
            ->join('memberships', 'subscriptions.membership_id', '=', 'memberships.id')
            ->sum('memberships.price');
        
        // Desglose por tipo de membresía
        $membershipBreakdown = $gym->subscriptions()
            ->whereBetween('start_date', [$startDate, $endDate])
            ->join('memberships', 'subscriptions.membership_id', '=', 'memberships.id')
            ->select('memberships.name', DB::raw('COUNT(*) as count'), DB::raw('SUM(memberships.price) as total'))
            ->groupBy('memberships.id', 'memberships.name')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->name => [
                    'count' => $item->count,
                    'total' => $item->total,
                ]];
            })
            ->toArray();
        
        // Crear o actualizar el reporte
        return GymReport::updateOrCreate(
            [
                'gym_id' => $gym->id,
                'report_type' => 'yearly',
                'year' => $year,
            ],
            [
                'total_income' => $totalIncome,
                'active_subscriptions' => $activeSubscriptions,
                'new_subscriptions' => $newSubscriptions,
                'expired_subscriptions' => $expiredSubscriptions,
                'membership_breakdown' => $membershipBreakdown,
            ]
        );
    }
    
    /**
     * Genera todos los reportes pendientes para un gimnasio
     *
     * @param Gym $gym
     * @return void
     */
    public function generatePendingReports(Gym $gym): void
    {
        $now = Carbon::now();
        $currentYear = $now->year;
        $currentMonth = $now->month;
        
        // Generar reportes mensuales desde el inicio del gimnasio hasta el mes anterior
        $firstSubscription = $gym->subscriptions()->orderBy('start_date')->first();
        
        if ($firstSubscription) {
            $startDate = Carbon::parse($firstSubscription->start_date);
            $startYear = $startDate->year;
            $startMonth = $startDate->month;
            
            for ($year = $startYear; $year <= $currentYear; $year++) {
                $endMonth = ($year == $currentYear) ? $currentMonth - 1 : 12;
                
                for ($month = ($year == $startYear ? $startMonth : 1); $month <= $endMonth; $month++) {
                    $this->generateMonthlyReport($gym, $year, $month);
                }
                
                // Generar reporte anual si estamos en el año actual o si es un año completo
                if ($year < $currentYear || ($year == $currentYear && $currentMonth == 12)) {
                    $this->generateYearlyReport($gym, $year);
                }
            }
        }
    }
} 