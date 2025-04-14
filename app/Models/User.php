<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    /**
     * Get the gyms owned by the user.
     */
    public function ownedGyms(): HasMany
    {
        return $this->hasMany(Gym::class, 'owner_id');
    }

    /**
     * Get the gyms where the user is a staff member.
     */
    public function staffGyms(): BelongsToMany
    {
        return $this->belongsToMany(Gym::class)
            ->withPivot('role', 'is_active')
            ->withTimestamps();
    }

    /**
     * Get all gyms associated with the user (both owned and staff).
     */
    public function allGyms()
    {
        return $this->ownedGyms->merge($this->staffGyms);
    }

    /**
     * Check if the user owns a specific gym.
     */
    public function ownsGym(Gym $gym): bool
    {
        return $this->ownedGyms()->where('id', $gym->id)->exists();
    }

    /**
     * Check if the user is a staff member of a specific gym.
     */
    public function isStaffOfGym(Gym $gym): bool
    {
        return $this->staffGyms()->where('gym_id', $gym->id)->exists();
    }

    /**
     * Get the role of the user in a specific gym.
     */
    public function getRoleInGym(Gym $gym): ?string
    {
        if ($this->ownsGym($gym)) {
            return 'owner';
        }

        $staffRelation = $this->staffGyms()->where('gym_id', $gym->id)->first();
        return $staffRelation ? $staffRelation->pivot->role : null;
    }

    /**
     * Check if the user has a specific role in a gym.
     */
    public function hasRoleInGym(Gym $gym, string $role): bool
    {
        return $this->getRoleInGym($gym) === $role;
    }

    /**
     * Get the user's preferences.
     */
    public function preferences(): HasMany
    {
        return $this->hasMany(UserPreference::class);
    }

    /**
     * Get a specific preference value.
     */
    public function getPreference(string $key, $default = null)
    {
        $cacheKey = "user.{$this->id}.preference.{$key}";
        
        return Cache::remember($cacheKey, now()->addHours(24), function () use ($key, $default) {
            $preference = $this->preferences()->where('key', $key)->first();
            return $preference ? $preference->value : $default;
        });
    }

    /**
     * Set a preference value.
     */
    public function setPreference(string $key, $value): void
    {
        $cacheKey = "user.{$this->id}.preference.{$key}";
        
        $this->preferences()->updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
        
        Cache::forget($cacheKey);
    }

    /**
     * Get the current gym for the user.
     */
    public function getCurrentGym()
    {
        $gymId = $this->getPreference('current_gym_id');
        
        if (!$gymId) {
            // Si no hay preferencia, intentar obtener el primer gimnasio
            $gym = $this->ownedGyms()->first() ?? $this->staffGyms()->first();
            
            if ($gym) {
                $this->setPreference('current_gym_id', $gym->id);
                return $gym;
            }
            
            return null;
        }
        
        return Gym::find($gymId);
    }

    /**
     * Set the current gym for the user.
     */
    public function setCurrentGym(Gym $gym): void
    {
        // Verificar que el usuario tenga acceso al gimnasio
        if ($this->ownsGym($gym) || $this->isStaffOfGym($gym)) {
            $this->setPreference('current_gym_id', $gym->id);
        }
    }

    protected $listeners = ['gym-changed' => 'updateCurrentGym'];
    
    public function updateCurrentGym($gymId)
    {
        // Actualizar el componente
    }
}
