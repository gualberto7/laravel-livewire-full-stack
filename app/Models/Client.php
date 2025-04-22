<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory, HasUuids;

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

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function subscriptionHistories(): HasMany
    {
        return $this->hasMany(SubscriptionHistory::class);
    }
}
