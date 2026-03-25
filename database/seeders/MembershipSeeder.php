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
            'description' => '',
            'active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
