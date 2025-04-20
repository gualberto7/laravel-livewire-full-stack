<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    /** @use HasFactory<\Database\Factories\SubscriptionFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'client_id',
        'membership_id',
        'gym_id',
        'start_date',
        'end_date',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function membership(): BelongsTo
    {
        return $this->belongsTo(Membership::class);
    }

    public function gym(): BelongsTo
    {
        return $this->belongsTo(Gym::class);
    }

    /**
     * Obtiene el estado actual de la suscripción
     */
    public function getStatus(): string
    {
        if (!$this->start_date || !$this->end_date) {
            return 'inactive';
        }

        $now = now();

        if ($now->between($this->start_date, $this->end_date)) {
            return 'activa';
        }

        if ($now->lt($this->start_date)) {
            return 'pendiente';
        }

        return 'vencida';
    }

    /**
     * Obtiene el color asociado al estado actual
     */
    public function getStatusColor(): string
    {
        return match ($this->getStatus()) {
            'activa' => 'emerald',
            'pendiente' => 'amber',
            'vencida' => 'red',
            default => 'zinc',
        };
    }

    /**
     * Verifica si la suscripción está activa
     */
    public function isActive(): bool
    {
        return $this->getStatus() === 'activa';
    }

    /**
     * Verifica si la suscripción está pendiente
     */
    public function isPending(): bool
    {
        return $this->getStatus() === 'pendiente';
    }

    /**
     * Verifica si la suscripción está vencida
     */
    public function isExpired(): bool
    {
        return $this->getStatus() === 'vencida';
    }
}
