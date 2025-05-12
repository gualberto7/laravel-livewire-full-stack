<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory, HasUuids;

    protected $guarded = [];

    public function subscriptions(): BelongsToMany
    {
        return $this->belongsToMany(Subscription::class);
    }

    public function gym(): BelongsTo
    {
        return $this->belongsTo(Gym::class);
    }

    public function checkIns(): HasMany
    {
        return $this->hasMany(CheckIn::class);
    }

    public function hasCheckedInToday($gymId): bool
    {
        return $this->checkIns()
            ->forGym($gymId)
            ->forDate(now())
            ->exists();
    }

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
