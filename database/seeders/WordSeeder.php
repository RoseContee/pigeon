<?php

namespace Database\Seeders;

use App\Models\Word;
use Illuminate\Database\Seeder;

class WordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();

        Word::insert([
            'word' => 'call',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Word::insert([
            'word' => 'Zoom',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Word::insert([
            'word' => 'meeting',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Word::insert([
            'word' => 'invite',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
