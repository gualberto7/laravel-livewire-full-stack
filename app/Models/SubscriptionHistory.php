<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionHistory extends Model
{
    /** @use HasFactory<\Database\Factories\SubscriptionHistoryFactory> */
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'membership',
        'duration',
        'price',
        'client_id',
        'gym_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }
}
