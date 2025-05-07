<?php

namespace App\Rules;

use Closure;
use App\Models\Client;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueInGym implements ValidationRule
{
    public $gym;

    public function __construct()
    {
        $this->gym = auth()->user()->getCurrentGym();
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (Client::where('ci', $value)
            ->where('gym_id', $this->gym->id)
            ->exists()) {
            $fail('Este nro. de carnet ya está registrado en este gimnasio.');
        }
    }
}
