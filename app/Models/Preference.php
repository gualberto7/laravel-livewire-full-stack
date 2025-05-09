<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    protected $fillable = [
        'key',
        'value',
        'preferable_id',
        'preferable_type',
    ];
}