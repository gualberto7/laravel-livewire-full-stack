<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Membership extends Model
{
    /** @use HasFactory<\Database\Factories\MembershipFactory> */
    use HasFactory, HasUuids;

    protected $guarded = [];

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }
}
