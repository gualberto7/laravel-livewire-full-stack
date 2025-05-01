<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait VerifiesGymAccess
{
    /**
     * Verifica si el usuario actual tiene acceso al modelo del gimnasio especificado
     */
    public function verifyGymAccess(Model $model): void
    {
        if ($model->gym_id !== auth()->user()->getCurrentGym()->id) {
            abort(403, 'No tienes acceso a este recurso.');
        }
    }
} 