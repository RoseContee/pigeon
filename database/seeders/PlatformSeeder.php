<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();

        Platform::insert([
            'name' => 'LinkedIn',
            'url' => 'https://www.linkedin.com/',
            'active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
