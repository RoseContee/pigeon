<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();

        Setting::insert([
            'meta_key' => 'site_name',
            'meta_value' => 'Pigeon',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Setting::insert([
            'meta_key' => 'site_url',
            'meta_value' => 'https://joinpigeon.com/',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Setting::insert([
            'meta_key' => 'site_logo',
            'meta_value' => 'assets/images/logo.png',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Setting::insert([
            'meta_key' => 'favicon',
            'meta_value' => 'assets/images/logo.png',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Setting::insert([
            'meta_key' => 'contact_email',
            'meta_value' => 'hello@joinpigeon.com',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Setting::insert([
            'meta_key' => 'facebook_link',
            'meta_value' => 'https://www.facebook.com/joinpigeontoday/',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Setting::insert([
            'meta_key' => 'twitter_link',
            'meta_value' => 'https://twitter.com/joinpigeon/',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Setting::insert([
            'meta_key' => 'linkedin_link',
            'meta_value' => 'https://www.linkedin.com/company/joinpigeon/',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Setting::insert([
            'meta_key' => 'meta_title',
            'meta_value' => '',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Setting::insert([
            'meta_key' => 'meta_keywords',
            'meta_value' => '',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Setting::insert([
            'meta_key' => 'meta_description',
            'meta_value' => '',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Setting::insert([
            'meta_key' => 'how_video',
            'meta_value' => 'https://www.youtube.com/watch?v=qLdslXvkUdY',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
