<?php

namespace Database\Seeders;

use App\Models\App;
use Illuminate\Database\Seeder;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();
        App::insert([
            'name' => 'Google Meet',
            'active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        App::insert([
            'name' => 'Zoom',
            'active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
