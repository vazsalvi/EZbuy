<?php
session_start();
include('../includes/connect.php');
include('../functions/common_function.php');

// Get user ID from session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

// Handle quantity updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $cart_id => $quantity) {
        $quantity = max(1, min(10, (int)$quantity)); // Limit quantity between 1 and 10
        $cart_items = $con->query('cart', ['id' => $cart_id, 'user_id' => $user_id]);
        if (!empty($cart_items)) {
            $con->update('cart', $cart_id, ['quantity' => $quantity]);
        }
    }
}

// Handle item removal
if (isset($_GET['remove'])) {
    $cart_id = (int)$_GET['remove'];
    $cart_items = $con->query('cart', ['id' => $cart_id, 'user_id' => $user_id]);
    if (!empty($cart_items)) {
        $con->delete('cart', $cart_id);
    }
}

// Get cart items
$cart_items = [];
$total_price = 0;
if ($user_id) {
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - EZbuy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .cart-item {
            border: 1px solid #eee;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            background: white;
        }
        .cart-item img {
            max-width: 100px;
            height: auto;
            object-fit: cover;
        }
        .quantity-input {
            width: 70px;
            text-align: center;
        }
        .remove-item {
            color: #dc3545;
            cursor: pointer;
        }
        .remove-item:hover {
            color: #c82333;
        }
        .cart-summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            position: sticky;
            top: 20px;
        }
        .empty-cart {
            text-align: center;
            padding: 50px 0;
        }
        .empty-cart i {
            font-size: 48px;
            color: #ccc;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container my-5">
        <h2 class="mb-4">Shopping Cart</h2>

        <?php if (empty($cart_items)): ?>
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <h3>Your cart is empty</h3>
                <p>Looks like you haven't added any items to your cart yet.</p>
                <a href="../index.php" class="btn btn-primary">Continue Shopping</a>
            </div>
        <?php else: ?>
            <form method="post" action="">
                <div class="row">
                    <div class="col-lg-8">
                        <?php foreach ($cart_items as $item): ?>
                            <div class="cart-item">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <img src="../admin_area/product_images/<?php echo $item['product_image1']; ?>" 
                                             alt="<?php echo $item['product_title']; ?>" 
                                             class="img-fluid">
                                    </div>
                                    <div class="col-md-4">
                                        <h5><?php echo $item['product_title']; ?></h5>
                                        <p class="text-muted">Price: ₹<?php echo number_format($item['final_price'], 2); ?></p>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <input type="number" 
                                                   name="quantity[<?php echo $item['id']; ?>]" 
                                                   value="<?php echo $item['quantity']; ?>" 
                                                   min="1" 
                                                   max="10" 
                                                   class="form-control quantity-input">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="fw-bold">₹<?php echo number_format($item['final_price'] * $item['quantity'], 2); ?></p>
                                    </div>
                                    <div class="col-md-1">
                                        <a href="?remove=<?php echo $item['id']; ?>" 
                                           class="remove-item"
                                           onclick="return confirm('Are you sure you want to remove this item?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <div class="d-flex justify-content-between mt-3">
                            <a href="../index.php" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left"></i> Continue Shopping
                            </a>
                            <button type="submit" name="update_cart" class="btn btn-outline-secondary">
                                <i class="fas fa-sync"></i> Update Cart
                            </button>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="cart-summary">
                            <h4>Cart Summary</h4>
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
                            <?php if ($user_id): ?>
                                <a href="checkout.php" class="btn btn-primary w-100">
                                    Proceed to Checkout <i class="fas fa-arrow-right"></i>
                                </a>
                            <?php else: ?>
                                <a href="user_login.php" class="btn btn-primary w-100">
                                    Login to Checkout <i class="fas fa-sign-in-alt"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <?php include('../includes/footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>