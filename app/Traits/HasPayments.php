<?php

namespace App\Traits;

use App\Models\Payment;

trait HasPayments
{
    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function addPayment(Payment $payment): void
    {
        $this->payments()->create($payment->toArray());
    }
}
