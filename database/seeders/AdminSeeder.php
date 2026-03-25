<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();

        Admin::insert([
            'email' => 'admin@admin.com',
            'password' => Hash::make(123456),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
