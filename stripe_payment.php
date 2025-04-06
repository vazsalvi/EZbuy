<?php
require 'vendor/autoload.php';
require('includes/connect.php');

\Stripe\Stripe::setApiKey('sk_test_51R9OKPQTxFpWivLcgIMJnnV5XkIqzi2ZciMkLfRxR3rH5Y7fqpAyKX8FCyL3K0TMbWk0InvRGpILnPvK41n6aAES00tZLtjo0p');

header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://localhost/Ai_driven_ecommerce';

$checkout_session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'inr',
            'product_data' => [
                'name' => 'Test Product',
            ],
            'unit_amount' => 50000,
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => $YOUR_DOMAIN . '/payment_success.php?session_id={CHECKOUT_SESSION_ID}',
    'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
]);

echo json_encode(['id' => $checkout_session->id]);
?>
