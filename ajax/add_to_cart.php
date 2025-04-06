<?php
session_start();
include("../includes/connect.php");

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['error' => 'Please login first']));
}

$user_id = $_SESSION['user_id'];
$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

if ($product_id > 0) {
    // Check if product exists
    $products = $con->query('products', ['id' => $product_id]);
    if (!empty($products)) {
        // Add to cart
        $result = addToCart($con, $user_id, $product_id, $quantity);
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Failed to add to cart']);
        }
    } else {
        echo json_encode(['error' => 'Product not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid product ID']);
}