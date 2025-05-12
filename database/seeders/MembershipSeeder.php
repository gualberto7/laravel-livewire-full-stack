<?php

namespace Database\Seeders;

use App\Models\Gym;
use App\Models\Membership;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gym = Gym::where('email', 'gym@test.com')->first();
        Membership::factory()->create([
            'name' => 'Mensual',
            'price' => 200,
            'duration' => 30,
            'description' => 'Membership 1 description',
            'gym_id' => $gym->id,
        ]);

        $gym2 = Gym::where('email', 'gym2@test.com')->first();
        Membership::factory()->create([
            'name' => 'Mensual',
            'price' => 200,
            'duration' => 30,
            'gym_id' => $gym2->id,
        ]);
        Membership::factory()->create([
            'name' => 'Anual',
            'price' => 2000,
            'duration' => 365,
            'max_installments' => 4,
            'gym_id' => $gym2->id,
        ]);
        Membership::factory()->create([
            'name' => 'Promo 2 x 1',
            'price' => 300,
            'duration' => 30,
            'is_promo' => true,
            'promo_start_date' => now(),
            'promo_end_date' => now()->addDays(5),
            'max_clients' => 2,
            'gym_id' => $gym2->id,
        ]);
        
        
    }
}
