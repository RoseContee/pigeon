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
            'image' => 'app/google-meet.png',
            'active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        App::insert([
            'name' => 'Zoom',
            'image' => 'app/zoom.png',
            'active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
