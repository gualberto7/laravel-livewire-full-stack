<?php

namespace App\Traits;

trait HasCurrentGym
{
    public $currentGym;

    public function mount()
    {
        $this->currentGym = app('current-gym');
    }
} 