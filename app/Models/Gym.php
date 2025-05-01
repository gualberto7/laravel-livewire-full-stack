<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Gym extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'address',
        'phone',
        'email',
        'website',
        'logo',
        'is_active',
        'owner_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the owner of the gym.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the users associated with the gym.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the clients associated with the gym.
     */
    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    /**
     * Get the admins of the gym.
     */
    public function admins()
    {
        return $this->users()->wherePivot('role', 'admin');
    }

    /**
     * Get the instructors of the gym.
     */
    public function instructors()
    {
        return $this->users()->wherePivot('role', 'instructor');
    }

    /**
     * Check if a user is the owner of the gym.
     */
    public function isOwnedBy(User $user): bool
    {
        return $this->owner_id === $user->id;
    }

    /**
     * Check if a user has a specific role in the gym.
     */
    public function userHasRole(User $user, string $role): bool
    {
        return $this->users()
            ->where('user_id', $user->id)
            ->wherePivot('role', $role)
            ->wherePivot('is_active', true)
            ->exists();
    }

    /**
     * Add a user to the gym with a specific role.
     */
    public function addUser(User $user, string $role): void
    {
        $this->users()->attach($user->id, [
            'role' => $role,
            'is_active' => true,
        ]);
    }

    /**
     * Remove a user from the gym.
     */
    public function removeUser(User $user): void
    {
        $this->users()->detach($user->id);
    }

    /**
     * Update a user's role in the gym.
     */
    public function updateUserRole(User $user, string $role): void
    {
        $this->users()->updateExistingPivot($user->id, [
            'role' => $role,
        ]);
    }

    /**
     * Deactivate a user in the gym.
     */
    public function deactivateUser(User $user): void
    {
        $this->users()->updateExistingPivot($user->id, [
            'is_active' => false,
        ]);
    }

    /**
     * Activate a user in the gym.
     */
    public function activateUser(User $user): void
    {
        $this->users()->updateExistingPivot($user->id, [
            'is_active' => true,
        ]);
    }

    /**
     * Get the memberships of the gym.
     */
    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class);
    }

    /**
     * Get the subscriptions of the gym.
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
