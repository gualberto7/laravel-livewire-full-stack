<?php

use App\Models\Gym;
use App\Models\User;
use App\Models\Client;
use App\Models\Membership;
use App\Models\Subscription;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

pest()->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Feature', 'Unit')
    ->beforeEach(function () {
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    });

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function addRole($user, $role)
{
    $role = Role::whereName($role)->first();
    $user->assignRole($role);
}

function createUserGymMembership($role)
{
    $user = User::factory()->create();
    addRole($user, $role);

    $gym = $role === 'gym-admin' ? Gym::factory()->create() : Gym::factory()->create(['owner_id' => $user->id]);

    if($role === 'gym-admin') {
        $user->update(['gym_id' => $gym->id]);
    }
    $membership = Membership::factory()->create(['gym_id' => $gym->id]);

    return compact('user', 'gym', 'membership');
}

function createUserGymMembershipAndSubscription($role)
{
    $data = createUserGymMembership($role);
    $client = Client::factory()->create();
    $subscription = Subscription::factory()->create([
        'gym_id' => $data['gym']->id,
        'client_id' => $client->id,
        'membership_id' => $data['membership']->id,
    ]);

    return array_merge($data, compact('client', 'subscription'));
}
