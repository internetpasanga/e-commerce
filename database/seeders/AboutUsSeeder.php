<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::set('about_us_title', 'About Us');

        Setting::set('about_us_content', <<<'HTML'
            <p>Welcome to Urban Basket, your one-stop destination for electronics, fashion, and home essentials. Since our founding, we've been committed to bringing quality products to your doorstep at honest prices.</p>
            <p>What started as a small idea has grown into a store trusted by thousands of shoppers across India. We work directly with reliable brands and sellers to make sure every product we list meets our standards for quality and value.</p>
            <h3>Our Mission</h3>
            <p>We believe online shopping should be simple, transparent, and reliable. From browsing to checkout to delivery, we aim to make every step of your shopping experience effortless.</p>
            <h3>Why Shop With Us</h3>
            <ul>
                <li>Wide range of everyday essentials across multiple categories</li>
                <li>Secure payments with Cash on Delivery and online payment options</li>
                <li>Fast, reliable shipping across India</li>
                <li>Easy returns and dedicated customer support</li>
            </ul>
            <p>Thank you for choosing Urban Basket. We're glad to have you with us!</p>
            HTML);
    }
}
