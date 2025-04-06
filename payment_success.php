<?php
require('includes/connect.php');

$orderId = $_GET['order_id'];

// Update order status in the database
$query = "UPDATE orders SET status='paid' WHERE order_id='$orderId'";
mysqli_query($con, $query);

// Display success message
echo "<h1>Payment Successful!</h1>";
echo "<p>Your order ID is: " . $orderId . "</p>";
?>
