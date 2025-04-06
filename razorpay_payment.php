<?php
require('includes/connect.php');

// Razorpay API keys
$keyId = 'YOUR_RAZORPAY_KEY_ID';
$keySecret = 'YOUR_RAZORPAY_KEY_SECRET';

// Include Razorpay PHP SDK
require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;

$api = new Api($keyId, $keySecret);

// Create an order
$orderData = [
    'receipt'         => 3456,
    'amount'          => 50000, // 50000 paise = 500 INR
    'currency'        => 'INR',
    'payment_capture' => 1 // auto capture
];

$order = $api->order->create($orderData);
$orderId = $order['id'];

// Display order ID
echo "Order ID: " . $orderId;

// Store order in database (for demonstration purposes)
$query = "INSERT INTO orders (order_id, status) VALUES ('$orderId', 'created')";
mysqli_query($con, $query);

// Redirect to payment page
header("Location: payment_page.php?order_id=$orderId");
?>
