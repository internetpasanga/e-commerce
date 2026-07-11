<?php

return [

    'verify-email' => [
        'name' => 'Email Verification',
        'subject' => 'Verify your email address',
        'description' => 'Sent when a customer registers. Available variables: {{ name }}, {{ verification_url }}',
        'body' => <<<'HTML'
            <p>Hi {{ name }},</p>
            <p>Thanks for signing up! Please click the button below to verify your email address.</p>
            <p><a href="{{ verification_url }}" style="display:inline-block;padding:10px 20px;background:#4f46e5;color:#fff;text-decoration:none;border-radius:6px;">Verify Email Address</a></p>
            <p>If you did not create an account, no further action is required.</p>
            HTML,
    ],

    'reset-password' => [
        'name' => 'Password Reset',
        'subject' => 'Reset your password',
        'description' => 'Sent when a customer requests a password reset. Available variables: {{ name }}, {{ reset_url }}',
        'body' => <<<'HTML'
            <p>Hi {{ name }},</p>
            <p>You are receiving this email because we received a password reset request for your account.</p>
            <p><a href="{{ reset_url }}" style="display:inline-block;padding:10px 20px;background:#4f46e5;color:#fff;text-decoration:none;border-radius:6px;">Reset Password</a></p>
            <p>This password reset link will expire in 60 minutes. If you did not request a password reset, no further action is required.</p>
            HTML,
    ],

    'order-confirmation' => [
        'name' => 'Order Confirmation',
        'subject' => 'Your order {{ order_number }} has been placed!',
        'description' => 'Sent when a customer places an order. Available variables: {{ name }}, {{ order_number }}, {{ grand_total }}, {{ order_url }}',
        'body' => <<<'HTML'
            <p>Hi {{ name }},</p>
            <p>Thank you for your order! We've received order <strong>{{ order_number }}</strong> and it's now being processed.</p>
            <p><strong>Order Total: ₹{{ grand_total }}</strong></p>
            <p><a href="{{ order_url }}" style="display:inline-block;padding:10px 20px;background:#4f46e5;color:#fff;text-decoration:none;border-radius:6px;">View Order</a></p>
            <p>We'll let you know once your order ships.</p>
            HTML,
    ],

    'contact-inquiry' => [
        'name' => 'Contact Inquiry Notification',
        'subject' => 'New contact inquiry from {{ name }}',
        'description' => 'Sent to the store\'s contact email when a customer submits the Contact Us form. Available variables: {{ name }}, {{ email }}, {{ subject }}, {{ message }}',
        'body' => <<<'HTML'
            <p>You have received a new inquiry via the Contact Us form.</p>
            <p><strong>Name:</strong> {{ name }}</p>
            <p><strong>Email:</strong> {{ email }}</p>
            <p><strong>Subject:</strong> {{ subject }}</p>
            <p><strong>Message:</strong><br>{{ message }}</p>
            HTML,
    ],

];
