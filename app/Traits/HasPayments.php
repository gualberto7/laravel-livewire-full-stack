<?php

namespace App\Traits;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasPayments
{
    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function addPayment($payment = null): void
    {
        if ($payment) {
            $this->payments()->create($payment);
        } else {
            $this->payments()->create([
                'method' => 'cash',
                'status' => 'pending',
            ]);
        }
    }
}
