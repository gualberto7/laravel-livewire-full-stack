<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GymReport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'gym_id',
        'report_type',
        'year',
        'month',
        'total_income',
        'active_subscriptions',
        'new_subscriptions',
        'expired_subscriptions',
        'membership_breakdown',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_income' => 'decimal:2',
        'active_subscriptions' => 'integer',
        'new_subscriptions' => 'integer',
        'expired_subscriptions' => 'integer',
        'membership_breakdown' => 'array',
    ];

    /**
     * Get the gym that owns the report.
     */
    public function gym(): BelongsTo
    {
        return $this->belongsTo(Gym::class);
    }

    /**
     * Scope a query to only include monthly reports.
     */
    public function scopeMonthly($query)
    {
        return $query->where('report_type', 'monthly');
    }

    /**
     * Scope a query to only include yearly reports.
     */
    public function scopeYearly($query)
    {
        return $query->where('report_type', 'yearly');
    }

    /**
     * Scope a query to only include reports for a specific year.
     */
    public function scopeForYear($query, $year)
    {
        return $query->where('year', $year);
    }

    /**
     * Scope a query to only include reports for a specific month.
     */
    public function scopeForMonth($query, $month)
    {
        return $query->where('month', $month);
    }

    /**
     * Scope a query to only include reports for a specific gym.
     */
    public function scopeForGym($query, $gymId)
    {
        return $query->where('gym_id', $gymId);
    }
} 