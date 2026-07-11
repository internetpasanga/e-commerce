<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\Concerns\GeneratesPlaceholderImages;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use GeneratesPlaceholderImages;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productsByCategory = [
            'Electronics' => [
                ['name' => 'Wireless Bluetooth Headphones', 'price' => 2499, 'mrp' => 3499, 'color' => '#2563eb'],
                ['name' => '4K Ultra HD Smart TV 43"', 'price' => 27999, 'mrp' => 32999, 'color' => '#1d4ed8'],
                ['name' => 'Portable Power Bank 20000mAh', 'price' => 1299, 'mrp' => 1299, 'color' => '#3b82f6'],
            ],
            'Fashion' => [
                ['name' => "Men's Slim Fit Casual Shirt", 'price' => 899, 'mrp' => 1299, 'color' => '#db2777'],
                ['name' => "Women's Summer Floral Dress", 'price' => 1499, 'mrp' => 1999, 'color' => '#ec4899'],
                ['name' => 'Leather Analog Wrist Watch', 'price' => 1999, 'mrp' => 1999, 'color' => '#be185d'],
            ],
            'Home & Kitchen' => [
                ['name' => 'Non-Stick Cookware Set (5 Pcs)', 'price' => 2199, 'mrp' => 2799, 'color' => '#059669'],
                ['name' => 'Electric Kettle 1.8L', 'price' => 799, 'mrp' => 999, 'color' => '#10b981'],
                ['name' => 'Cotton Bedsheet with Pillow Covers', 'price' => 999, 'mrp' => 999, 'color' => '#047857'],
            ],
            'Beauty & Personal Care' => [
                ['name' => 'Vitamin C Face Serum', 'price' => 599, 'mrp' => 799, 'color' => '#d97706'],
                ['name' => 'Herbal Shampoo & Conditioner Combo', 'price' => 449, 'mrp' => 449, 'color' => '#f59e0b'],
            ],
            'Sports & Fitness' => [
                ['name' => 'Yoga Mat with Carry Strap', 'price' => 699, 'mrp' => 899, 'color' => '#dc2626'],
                ['name' => 'Adjustable Dumbbell Set 10kg', 'price' => 2999, 'mrp' => 3799, 'color' => '#ef4444'],
            ],
            'Books & Stationery' => [
                ['name' => 'Hardcover Ruled Notebook Set (3 Pcs)', 'price' => 349, 'mrp' => 349, 'color' => '#7c3aed'],
                ['name' => 'Premium Gel Pen Set (10 Pcs)', 'price' => 249, 'mrp' => 299, 'color' => '#8b5cf6'],
            ],
        ];

        $priority = 0;

        foreach ($productsByCategory as $categoryName => $products) {
            $category = Category::where('name', $categoryName)->first();

            if (! $category) {
                continue;
            }

            foreach ($products as $item) {
                $product = Product::updateOrCreate(
                    ['name' => $item['name']],
                    [
                        'category_id' => $category->id,
                        'description' => "The {$item['name']} offers great quality and value, perfect for everyday use.",
                        'mrp' => $item['mrp'],
                        'sale_price' => $item['price'],
                        'stock' => rand(5, 50),
                        'thumbnail' => $this->placeholderImage('products', $item['name'], $item['color'], 800, 800),
                        'priority' => $priority++,
                        'status' => true,
                    ]
                );

                if ($product->images()->count() === 0) {
                    foreach (range(1, 2) as $i) {
                        $product->images()->create([
                            'image' => $this->placeholderImage('products', $item['name'].' '.$i, $item['color'], 800, 800),
                        ]);
                    }
                }
            }
        }
    }
}
