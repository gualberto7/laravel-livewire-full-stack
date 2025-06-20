<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\HasPreferences;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasUuids, Notifiable, HasRoles, HasPreferences;

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
        'gym_id',
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
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

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
    public function staffGym(): BelongsTo
    {
        return $this->belongsTo(Gym::class, 'gym_id');
    }

    /**
     * Get all gyms associated with the user (both owned and staff).
     */
    public function allGyms()
    {
        return $this->ownedGyms;
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
        return $this->staffGym->id === $gym->id;
    }

    /**
     * Get the current gym for the user.
     */
    public function getCurrentGym()
    {
        $gymId = $this->getPreference('current_gym_id');
        
        if (!$gymId) {
            // Si no hay preferencia, intentar obtener el primer gimnasio
            $gym = $this->ownedGyms()->first() ?? $this->staffGym;
            
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

    public function getRoleNameAttribute(): string
    {
        if (!isset($this->role)) {
            return 'Sin rol';
        }

        return match($this->role) {
            'admin' => 'Administrador',
            'instructor' => 'Instructor',
            'receptionist' => 'Recepcionista',
            default => ucfirst($this->role),
        };
    }
}
