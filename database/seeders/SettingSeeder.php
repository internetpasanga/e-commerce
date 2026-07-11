<?php

namespace Database\Seeders;

use App\Models\Setting;
use Database\Seeders\Concerns\GeneratesPlaceholderImages;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    use GeneratesPlaceholderImages;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $logo = $this->placeholderImage('settings', 'LOGO', '#4f46e5', 320, 100);

        $values = [
            'site_name' => 'Urban Basket',
            'logo' => $logo,
            'meta_title' => 'Urban Basket - Everyday Essentials Online',
            'meta_description' => 'Shop electronics, fashion, home essentials and more at Urban Basket. Fast delivery, secure payments, easy returns.',
            'meta_keywords' => 'online shopping, ecommerce, electronics, fashion, home essentials',
            'primary_color' => '#4f46e5',
            'secondary_color' => '#0f172a',
            'email' => 'support@urbanbasket.test',
            'phone' => '+91 98765 43210',
            'address' => '221B Commerce Street, Bengaluru, Karnataka, India',
            'social_facebook' => 'https://facebook.com/urbanbasket',
            'social_instagram' => 'https://instagram.com/urbanbasket',
            'social_twitter' => 'https://x.com/urbanbasket',
            'social_youtube' => 'https://youtube.com/@urbanbasket',
        ];

        foreach ($values as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
