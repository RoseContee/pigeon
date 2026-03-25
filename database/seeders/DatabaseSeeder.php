<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            AdminSeeder::class,
            AppSeeder::class,
            MailTemplateSeeder::class,
            MembershipPackageSeeder::class,
            MembershipSeeder::class,
            PlatformSeeder::class,
            SettingSeeder::class,
            WordSeeder::class,
        ]);
    }
}
