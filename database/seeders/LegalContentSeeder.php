<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class LegalContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lastUpdated = now()->format('F j, Y');

        Setting::set('terms_title', 'Terms of Service');
        Setting::set('terms_content', str_replace('{{ last_updated }}', $lastUpdated, $this->termsContent()));

        Setting::set('privacy_title', 'Privacy Policy');
        Setting::set('privacy_content', str_replace('{{ last_updated }}', $lastUpdated, $this->privacyContent()));
    }

    private function termsContent(): string
    {
        return <<<'HTML'
            <p><em>Last updated: {{ last_updated }}</em></p>

            <p>Welcome to Urban Basket. These Terms of Service ("Terms") govern your access to and use of our website and the purchase of products through it. By creating an account, placing an order, or otherwise using our site, you agree to be bound by these Terms. If you do not agree, please do not use our website.</p>

            <h3>1. Account Registration</h3>
            <p>To place an order, you'll need to create an account with a valid email address. You're responsible for keeping your login credentials confidential and for all activity that happens under your account. Please notify us immediately if you suspect any unauthorized use.</p>

            <h3>2. Products and Pricing</h3>
            <p>We make every effort to display product details, images, and pricing accurately. However, we do not warrant that product descriptions or other content are error-free. Prices are subject to change without notice, and we reserve the right to correct any pricing errors, even after an order has been placed.</p>

            <h3>3. Orders and Payment</h3>
            <p>When you place an order, you're making an offer to purchase the selected products. We reserve the right to accept or decline any order for reasons including product availability, errors in pricing or product information, or suspected fraudulent activity.</p>
            <p>We accept Cash on Delivery (COD) as well as online payments processed securely through Razorpay, which supports credit/debit cards, UPI, and net banking. We do not store your card or bank details on our servers.</p>

            <h3>4. Shipping and Delivery</h3>
            <p>Estimated delivery timelines are provided at checkout and on the order confirmation page. While we work hard to meet these estimates, delivery times are not guaranteed and may be affected by factors outside our control, such as courier delays or circumstances beyond our reasonable control.</p>

            <h3>5. Cancellations, Returns and Refunds</h3>
            <p>Orders may be cancelled while they are still pending or being processed by contacting our support team. Once an order has been shipped, it cannot be cancelled but may be eligible for return.</p>
            <p>If you're not satisfied with your order, you may request a return within 7 days of delivery, provided the product is unused, undamaged, and in its original packaging. Refunds for eligible returns will be processed to the original payment method within a reasonable timeframe once the returned item is received and inspected.</p>

            <h3>6. Product Reviews</h3>
            <p>Customers who have received a delivered order may submit a review for the products they purchased. Reviews are moderated before being published and must not contain offensive, misleading, or unlawful content. We reserve the right to remove any review at our discretion.</p>

            <h3>7. User Conduct</h3>
            <p>You agree not to misuse our website, including attempting to gain unauthorized access to our systems, interfering with the site's normal operation, or using the site for any unlawful purpose.</p>

            <h3>8. Intellectual Property</h3>
            <p>All content on this website, including text, graphics, logos, and images, is the property of Urban Basket or its licensors and is protected by applicable intellectual property laws. You may not reproduce, distribute, or use this content without our prior written consent.</p>

            <h3>9. Limitation of Liability</h3>
            <p>To the fullest extent permitted by law, Urban Basket shall not be liable for any indirect, incidental, or consequential damages arising from your use of our website or products purchased through it.</p>

            <h3>10. Changes to These Terms</h3>
            <p>We may update these Terms from time to time. Continued use of our website after changes are posted constitutes your acceptance of the revised Terms.</p>

            <h3>11. Contact Us</h3>
            <p>If you have any questions about these Terms, please reach out through our <a href="/contact-us">Contact Us</a> page.</p>
            HTML;
    }

    private function privacyContent(): string
    {
        return <<<'HTML'
            <p><em>Last updated: {{ last_updated }}</em></p>

            <p>This Privacy Policy explains how Urban Basket ("we", "us", "our") collects, uses, and protects your personal information when you use our website and services.</p>

            <h3>1. Information We Collect</h3>
            <ul>
                <li><strong>Account information:</strong> name, email address, phone number, and password when you register.</li>
                <li><strong>Order information:</strong> shipping and billing addresses, order history, and items purchased.</li>
                <li><strong>Payment information:</strong> processed securely by our payment partner, Razorpay. We do not store your full card or bank account details on our servers.</li>
                <li><strong>Usage information:</strong> pages visited, products viewed, and general browsing activity, used to improve your shopping experience.</li>
            </ul>

            <h3>2. How We Use Your Information</h3>
            <ul>
                <li>To process and fulfil your orders, including shipping and delivery</li>
                <li>To communicate with you about your orders, account, and customer support requests</li>
                <li>To send order confirmations, shipping updates, and (if you opt in) promotional communications</li>
                <li>To improve our website, products, and services</li>
                <li>To detect and prevent fraud or misuse of our platform</li>
            </ul>

            <h3>3. Sharing Your Information</h3>
            <p>We do not sell your personal information. We share your information only with trusted third parties as necessary to operate our business, including:</p>
            <ul>
                <li>Payment processors (such as Razorpay) to complete transactions</li>
                <li>Shipping and logistics partners to deliver your orders</li>
                <li>Email service providers to send transactional and account-related emails</li>
            </ul>
            <p>We may also disclose information if required to do so by law or in response to valid legal requests.</p>

            <h3>4. Cookies</h3>
            <p>We use cookies and similar technologies to keep you signed in, remember items in your cart and wishlist, and understand how our website is used. You can control cookies through your browser settings, though disabling them may affect certain site features.</p>

            <h3>5. Data Security</h3>
            <p>We take reasonable technical and organizational measures to protect your personal information from unauthorized access, alteration, or disclosure. However, no method of transmission over the internet is completely secure, and we cannot guarantee absolute security.</p>

            <h3>6. Data Retention</h3>
            <p>We retain your personal information for as long as necessary to provide our services, comply with legal obligations, resolve disputes, and enforce our agreements.</p>

            <h3>7. Your Rights</h3>
            <p>You may access, update, or correct your account information at any time from your profile. You may also request deletion of your account by contacting our support team, subject to any records we're required to retain for legal or accounting purposes.</p>

            <h3>8. Children's Privacy</h3>
            <p>Our website is not intended for children under the age of 18. We do not knowingly collect personal information from children.</p>

            <h3>9. Changes to This Policy</h3>
            <p>We may update this Privacy Policy from time to time to reflect changes in our practices. We encourage you to review this page periodically.</p>

            <h3>10. Contact Us</h3>
            <p>If you have any questions about this Privacy Policy or how we handle your personal information, please reach out through our <a href="/contact-us">Contact Us</a> page.</p>
            HTML;
    }
}
