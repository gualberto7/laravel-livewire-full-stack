<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory;

    protected $guarded = [];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Obtiene los gimnasios a los que el cliente se ha suscrito
     */
    public function gyms(): BelongsToMany
    {
        return $this->belongsToMany(Gym::class, 'client_gym')
            ->withTimestamps();
    }

    /**
     * Obtiene los check-ins del cliente
     */
    public function checkIns(): HasMany
    {
        return $this->hasMany(CheckIn::class);
    }

    /**
     * Verifica si el cliente ha hecho check-in hoy en el gimnasio especificado
     */
    public function hasCheckedInToday($gymId): bool
    {
        return $this->checkIns()
            ->forGym($gymId)
            ->forDate(now())
            ->exists();
    }

    /**
     * Registra un nuevo check-in para el cliente
     */
    public function checkIn($gymId, $userName): CheckIn
    {
        return $this->checkIns()->create([
            'gym_id' => $gymId,
            'created_by' => $userName,
            'updated_by' => $userName,
        ]);
    }

    /**
     * Registra una suscripción a un gimnasio
     */
    public function subscribeToGym($gymId): void
    {
        $existingRelation = $this->gyms()->where('gym_id', $gymId)->first();
        
        if (!$existingRelation) {
            $this->gyms()->attach($gymId);
        }
    }
}
