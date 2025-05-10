<?php

namespace App\Traits;

trait HasCurrentGym
{
    public $currentGym;

    public function initializeCurrentGym()
    {
        $this->currentGym = app('current-gym');
    }
} 