<?php

namespace Database\Seeders;

use App\Models\Membership;
use Illuminate\Database\Seeder;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();

        Membership::insert([
            'membership_package_id' => 1,
            'name' => 'Free',
            'price' => 0,
            'limitation' => 10,
            'event' => 1,
            'schedule' => 50,
            'description' => '10 Limitation
1 Events
10 Sessions',
            'active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
