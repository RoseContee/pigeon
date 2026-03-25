<?php

namespace Database\Seeders;

use App\Models\MembershipPackage;
use Illuminate\Database\Seeder;

class MembershipPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();

        MembershipPackage::insert([
            'name' => 'Monthly Plan',
            'period' => 1,
            'unit' => 'month',
            'discount' => 0,
            'active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
