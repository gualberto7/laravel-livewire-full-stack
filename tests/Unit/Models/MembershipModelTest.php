<?php

use App\Models\Gym;
use App\Models\Membership;

test('memnbersip belongs to a gym', function () {
    $membership = Membership::factory()->create();

    expect($membership->gym)->toBeInstanceOf(Gym::class);
});
