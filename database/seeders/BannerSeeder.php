<?php

namespace Database\Seeders;

use App\Models\Banner;
use Database\Seeders\Concerns\GeneratesPlaceholderImages;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    use GeneratesPlaceholderImages;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Big Season Sale',
                'sub_title' => 'Up to 50% off on Electronics',
                'title_position' => 'center',
                'button_text' => 'Shop Now',
                'button_url' => 'https://example.com/sale',
                'button_color' => '#4f46e5',
                'color' => '#2563eb',
            ],
            [
                'title' => 'New Fashion Arrivals',
                'sub_title' => 'Fresh styles for the new season',
                'title_position' => 'bottom-left',
                'button_text' => 'Explore Collection',
                'button_url' => 'https://example.com/fashion',
                'button_color' => '#db2777',
                'color' => '#db2777',
            ],
            [
                'title' => 'Home Essentials',
                'sub_title' => 'Everything you need for your home',
                'title_position' => 'top-right',
                'button_text' => 'View Deals',
                'button_url' => 'https://example.com/home',
                'button_color' => '#059669',
                'color' => '#059669',
            ],
        ];

        foreach ($banners as $index => $banner) {
            Banner::updateOrCreate(
                ['title' => $banner['title']],
                [
                    'sub_title' => $banner['sub_title'],
                    'image' => $this->placeholderImage('banners', $banner['title'], $banner['color'], 1600, 640),
                    'title_position' => $banner['title_position'],
                    'button_text' => $banner['button_text'],
                    'button_url' => $banner['button_url'],
                    'button_color' => $banner['button_color'],
                    'priority' => $index,
                    'status' => true,
                ]
            );
        }
    }
}
