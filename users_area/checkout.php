<?php
session_start();
include('../includes/connect.php');
include('../functions/common_function.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: user_login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Get user details
$user_data = $con->query('users', ['id' => $user_id]);
$user = !empty($user_data) ? $user_data[0] : null;

// Get cart items
$cart_items = [];
$total_price = 0;
$cart_data = $con->query('cart', ['user_id' => $user_id]);
foreach ($cart_data as $cart_item) {
    $products = $con->query('products', ['id' => $cart_item['product_id']]);
    if (!empty($products)) {
        $product = $products[0];
        $item = array_merge($cart_item, [
            'product_title' => $product['product_title'],
            'product_price' => $product['product_price'],
            'product_image1' => $product['product_image1'],
            'final_price' => isset($product['product_sale_price']) ? $product['product_sale_price'] : $product['product_price']
        ]);
        $cart_items[] = $item;
        $total_price += $item['final_price'] * $item['quantity'];
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $shipping_address = filter_input(INPUT_POST, 'shipping_address', FILTER_SANITIZE_STRING);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
    $pincode = filter_input(INPUT_POST, 'pincode', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);

    // Create order
    $order_id = $con->insert('orders', [
        'user_id' => $user_id,
        'total_amount' => $total_price + ($total_price >= 500 ? 0 : 50),
        'shipping_address' => $shipping_address,
        'city' => $city,
        'state' => $state,
        'pincode' => $pincode,
        'phone' => $phone,
        'status' => 'pending',
        'payment_status' => 'pending'
    ]);

    // Add order items
    foreach ($cart_items as $item) {
        $con->insert('order_items', [
            'order_id' => $order_id,
            'product_id' => $item['product_id'],
            'quantity' => $item['quantity'],
            'price' => $item['final_price']
        ]);
    }

    // Clear cart
    foreach ($cart_items as $item) {
        $con->delete('cart', $item['id']);
    }

    // Redirect to payment page
    header("Location: ../payment_page.php?order_id=$order_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - EZbuy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .order-summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            position: sticky;
            top: 20px;
        }
        .product-list {
            max-height: 300px;
            overflow-y: auto;
        }
        .product-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .product-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container my-5">
        <h2 class="mb-4">Checkout</h2>

        <?php if (empty($cart_items)): ?>
            <div class="alert alert-warning">
                Your cart is empty. Please add items to proceed with checkout.
                <a href="../index.php" class="btn btn-primary ms-3">Continue Shopping</a>
            </div>
        <?php else: ?>
            <form method="post" action="" class="needs-validation" novalidate>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h4>Shipping Information</h4>
                                <hr>
                                <div class="mb-3">
                                    <label for="shipping_address" class="form-label">Address</label>
                                    <textarea name="shipping_address" id="shipping_address" class="form-control" rows="3" required><?php echo isset($user['address']) ? $user['address'] : ''; ?></textarea>
                                    <div class="invalid-feedback">Please enter your shipping address.</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" name="city" id="city" class="form-control" value="<?php echo isset($user['city']) ? $user['city'] : ''; ?>" required>
                                        <div class="invalid-feedback">Please enter your city.</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="state" class="form-label">State</label>
                                        <input type="text" name="state" id="state" class="form-control" value="<?php echo isset($user['state']) ? $user['state'] : ''; ?>" required>
                                        <div class="invalid-feedback">Please enter your state.</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="pincode" class="form-label">PIN Code</label>
                                        <input type="text" name="pincode" id="pincode" class="form-control" pattern="[0-9]{6}" value="<?php echo isset($user['pincode']) ? $user['pincode'] : ''; ?>" required>
                                        <div class="invalid-feedback">Please enter a valid 6-digit PIN code.</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" name="phone" id="phone" class="form-control" pattern="[0-9]{10}" value="<?php echo isset($user['phone']) ? $user['phone'] : ''; ?>" required>
                                        <div class="invalid-feedback">Please enter a valid 10-digit phone number.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="order-summary">
                            <h4>Order Summary</h4>
                            <hr>
                            <div class="product-list">
                                <?php foreach ($cart_items as $item): ?>
                                    <div class="product-item">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h6 class="mb-0"><?php echo $item['product_title']; ?></h6>
                                                <small class="text-muted">Quantity: <?php echo $item['quantity']; ?></small>
                                            </div>
                                            <span>₹<?php echo number_format($item['final_price'] * $item['quantity'], 2); ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span>₹<?php echo number_format($total_price, 2); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping</span>
                                <span><?php echo $total_price >= 500 ? 'Free' : '₹50.00'; ?></span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <span class="fw-bold">Total</span>
                                <span class="fw-bold">₹<?php echo number_format($total_price + ($total_price >= 500 ? 0 : 50), 2); ?></span>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                Proceed to Payment <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <?php include('../includes/footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form validation
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>
</html>