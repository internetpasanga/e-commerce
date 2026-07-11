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
            'site_name' => 'Sample E-Commerse',
            'logo' => $logo,
            'meta_title' => 'Sample E-Commerse - Everyday Essentials Online',
            'meta_description' => 'Shop electronics, fashion, home essentials and more at Sample E-Commerse. Fast delivery, secure payments, easy returns.',
            'meta_keywords' => 'online shopping, ecommerce, electronics, fashion, home essentials',
            'primary_color' => '#4f46e5',
            'secondary_color' => '#0f172a',
            'email' => 'support@sampleecommerse.test',
            'phone' => '+91 98765 43210',
            'address' => '42, Anna Salai, T. Nagar, Chennai, Tamil Nadu 600017, India',
            'social_facebook' => 'https://facebook.com/sampleecommerse',
            'social_instagram' => 'https://instagram.com/sampleecommerse',
            'social_twitter' => 'https://x.com/sampleecommerse',
            'social_youtube' => 'https://youtube.com/@sampleecommerse',
        ];

        foreach ($values as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
