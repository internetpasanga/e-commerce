<?php

namespace Database\Seeders;

use App\Models\Category;
use Database\Seeders\Concerns\GeneratesPlaceholderImages;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    use GeneratesPlaceholderImages;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics', 'color' => '#2563eb'],
            ['name' => 'Fashion', 'color' => '#db2777'],
            ['name' => 'Home & Kitchen', 'color' => '#059669'],
            ['name' => 'Beauty & Personal Care', 'color' => '#d97706'],
            ['name' => 'Sports & Fitness', 'color' => '#dc2626'],
            ['name' => 'Books & Stationery', 'color' => '#7c3aed'],
        ];

        foreach ($categories as $index => $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                [
                    'image' => $this->placeholderImage('categories', $category['name'], $category['color'], 600, 600),
                    'status' => true,
                    'priority' => $index,
                ]
            );
        }
    }
}
