<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'How do I track my order?',
                'answer' => '<p>Once your order is placed, you can track its status anytime from <strong>My Orders</strong> in your account menu. You\'ll see updates as your order moves through processing, shipping, and delivery.</p>',
            ],
            [
                'question' => 'What payment methods do you accept?',
                'answer' => '<p>We accept Cash on Delivery (COD) as well as online payments via Razorpay, which supports credit/debit cards, UPI, and net banking.</p>',
            ],
            [
                'question' => 'What is your return policy?',
                'answer' => '<p>If you\'re not satisfied with your order, please contact our support team within 7 days of delivery. Products must be unused and in their original packaging to be eligible for a return.</p>',
            ],
            [
                'question' => 'How long does delivery take?',
                'answer' => '<p>Most orders are delivered within 3-7 business days, depending on your location. You\'ll receive updates by email as your order is processed and shipped.</p>',
            ],
            [
                'question' => 'Can I cancel my order after placing it?',
                'answer' => '<p>Orders can be cancelled from the admin side while they are still pending or processing. Please contact us as soon as possible if you\'d like to cancel an order.</p>',
            ],
            [
                'question' => 'Do you ship to my location?',
                'answer' => '<p>We currently ship across India. Shipping charges, if any, are shown at checkout before you place your order.</p>',
            ],
            [
                'question' => 'How can I write a product review?',
                'answer' => '<p>Once your order has been delivered, you can leave a review from the product page or from <strong>My Reviews</strong> in your account menu. Reviews are moderated before they appear publicly.</p>',
            ],
            [
                'question' => 'How do I contact customer support?',
                'answer' => '<p>You can reach us anytime through our <a href="/contact-us">Contact Us</a> page, and we\'ll get back to you as soon as possible.</p>',
            ],
        ];

        foreach ($faqs as $index => $faq) {
            Faq::query()->firstOrCreate(
                ['question' => $faq['question']],
                [
                    'answer' => $faq['answer'],
                    'priority' => $index,
                    'is_active' => true,
                ]
            );
        }
    }
}
