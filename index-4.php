<?php
session_start();
include("./includes/connect.php");
include("./functions/common_function.php");

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Get Electronics category ID
$categories = $con->query('categories', ['category_title' => 'Electronics']);
$category_id = !empty($categories) ? $categories[0]['id'] : 1;

// Fetch data
$featured_products = getFeaturedProducts($con, 8);
$hot_deals = getHotDeals($con, 4);
$new_arrivals = getNewArrivals($con, 8);
$top_rated = getTopRatedProducts($con, 4);
$brands = getBrandsByCategory($con, $category_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EZbuy - Electronic Store</title>
    <meta name="description" content="Your one-stop shop for all electronics">
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/icons/favicon-16x16.png">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/plugins/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/plugins/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/skins/skin-demo-4.css">
    <link rel="stylesheet" href="assets/css/demos/demo-4.css">
    <link rel="stylesheet" href="assets/css/chatbot.css">
</head>

<body>
    <div class="page-wrapper">
        <?php include("./includes/header.php")?>

        <main class="main">
            <!-- Hero Section -->
            <div class="intro-slider-container">
                <div class="owl-carousel owl-simple owl-light owl-nav-inside" data-toggle="owl" data-owl-options='{
                    "nav": false,
                    "dots": true,
                    "responsive": {
                        "992": {
                            "nav": true
                        }
                    }
                }'>
                    <div class="intro-slide" style="background-image: url(assets/images/demos-img/electronics.jpg);">
                        <div class="container intro-content">
                            <h3 class="intro-subtitle">Deals and Promotions</h3>
                            <h1 class="intro-title">Latest Tech Gadgets<br>Up to 50% Off</h1>
                            <a href="#hot-deals" class="btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Featured Products -->
            <div class="container">
                <h2 class="title text-center mb-4">Featured Products</h2>
                <div class="row">
                    <?php
                    if (!empty($featured_products)) {
                        foreach ($featured_products as $product) {
                            $discount = calculateDiscount($product['product_price'], $product['product_sale_price'] ?? null);
                            ?>
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="product">
                                    <figure class="product-media">
                                        <?php if ($discount > 0): ?>
                                            <span class="product-label label-sale">-<?php echo $discount; ?>%</span>
                                        <?php endif; ?>
                                        <a href="product.php?id=<?php echo $product['id']; ?>">
                                            <img src="<?php echo $product['product_image1']; ?>" alt="<?php echo $product['product_title']; ?>" class="product-image">
                                        </a>
                                        <div class="product-action">
                                            <a href="#" class="btn-product btn-cart" data-product-id="<?php echo $product['id']; ?>"><span>add to cart</span></a>
                                            <a href="#" class="btn-product btn-wishlist" data-product-id="<?php echo $product['id']; ?>"><span>add to wishlist</span></a>
                                        </div>
                                    </figure>
                                    <div class="product-body">
                                        <div class="product-cat">
                                            <a href="#">Electronics</a>
                                        </div>
                                        <h3 class="product-title">
                                            <a href="product.php?id=<?php echo $product['id']; ?>"><?php echo $product['product_title']; ?></a>
                                        </h3>
                                        <div class="product-price">
                                            <?php if (isset($product['product_sale_price'])): ?>
                                                <span class="new-price"><?php echo formatPrice($product['product_sale_price']); ?></span>
                                                <span class="old-price"><?php echo formatPrice($product['product_price']); ?></span>
                                            <?php else: ?>
                                                <span><?php echo formatPrice($product['product_price']); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="ratings-container">
                                            <div class="ratings">
                                                <?php echo displayRating($product['rating']); ?>
                                            </div>
                                            <span class="ratings-text">( <?php echo $product['review_count']; ?> Reviews )</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <!-- Hot Deals -->
            <div id="hot-deals" class="container">
                <h2 class="title text-center mb-4">Hot Deals</h2>
                <div class="row">
                    <?php
                    if (!empty($hot_deals)) {
                        foreach ($hot_deals as $deal) {
                            $discount = calculateDiscount($deal['product_price'], $deal['product_sale_price'] ?? null);
                            ?>
                            <div class="col-6 col-md-3">
                                <div class="product product-2">
                                    <figure class="product-media">
                                        <span class="product-label label-circle label-sale">-<?php echo $discount; ?>%</span>
                                        <a href="product.php?id=<?php echo $deal['id']; ?>">
                                            <img src="<?php echo $deal['product_image1']; ?>" alt="<?php echo $deal['product_title']; ?>" class="product-image">
                                        </a>
                                        <div class="product-action">
                                            <a href="#" class="btn-product btn-cart" data-product-id="<?php echo $deal['id']; ?>"><span>add to cart</span></a>
                                        </div>
                                    </figure>
                                    <div class="product-body">
                                        <h3 class="product-title">
                                            <a href="product.php?id=<?php echo $deal['id']; ?>"><?php echo $deal['product_title']; ?></a>
                                        </h3>
                                        <div class="product-price">
                                            <?php if (isset($deal['product_sale_price'])): ?>
                                                <span class="new-price"><?php echo formatPrice($deal['product_sale_price']); ?></span>
                                                <span class="old-price"><?php echo formatPrice($deal['product_price']); ?></span>
                                            <?php else: ?>
                                                <span><?php echo formatPrice($deal['product_price']); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <!-- New Arrivals -->
            <div class="container">
                <h2 class="title text-center mb-4">New Arrivals</h2>
                <div class="row">
                    <?php
                    if (!empty($new_arrivals)) {
                        foreach ($new_arrivals as $product) {
                            ?>
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="product">
                                    <figure class="product-media">
                                        <span class="product-label label-new">New</span>
                                        <a href="product.php?id=<?php echo $product['id']; ?>">
                                            <img src="<?php echo $product['product_image1']; ?>" alt="<?php echo $product['product_title']; ?>" class="product-image">
                                        </a>
                                        <div class="product-action">
                                            <a href="#" class="btn-product btn-cart" data-product-id="<?php echo $product['id']; ?>"><span>add to cart</span></a>
                                            <a href="#" class="btn-product btn-wishlist" data-product-id="<?php echo $product['id']; ?>"><span>add to wishlist</span></a>
                                        </div>
                                    </figure>
                                    <div class="product-body">
                                        <div class="product-cat">
                                            <a href="#">Electronics</a>
                                        </div>
                                        <h3 class="product-title">
                                            <a href="product.php?id=<?php echo $product['id']; ?>"><?php echo $product['product_title']; ?></a>
                                        </h3>
                                        <div class="product-price">
                                            <?php echo formatPrice($product['product_price']); ?>
                                        </div>
                                        <div class="ratings-container">
                                            <div class="ratings">
                                                <?php echo displayRating($product['rating']); ?>
                                            </div>
                                            <span class="ratings-text">( <?php echo $product['review_count']; ?> Reviews )</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <!-- Brands -->
            <div class="container">
                <h2 class="title text-center mb-4">Shop by Brand</h2>
                <div class="owl-carousel owl-simple" data-toggle="owl" data-owl-options='{
                    "nav": false, 
                    "dots": false,
                    "margin": 30,
                    "loop": false,
                    "responsive": {
                        "0": {
                            "items":2
                        },
                        "420": {
                            "items":3
                        },
                        "600": {
                            "items":4
                        },
                        "900": {
                            "items":5
                        },
                        "1024": {
                            "items":6
                        }
                    }
                }'>
                    <?php
                    if (!empty($brands)) {
                        foreach ($brands as $brand) {
                            ?>
                            <a href="#" class="brand">
                                <img src="<?php echo $brand['brand_image']; ?>" alt="<?php echo $brand['brand_title']; ?>">
                            </a>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </main>

        <?php include("./includes/footer.php")?>
    </div>

    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div>
    <div class="mobile-menu-container"></div>

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.hoverIntent.min.js"></script>
    <script src="assets/js/jquery.waypoints.min.js"></script>
    <script src="assets/js/superfish.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/bootstrap-input-spinner.js"></script>
    <script src="assets/js/jquery.plugin.min.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/jquery.countdown.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/demos/demo-4.js"></script>
    
    <script>
    $(document).ready(function() {
        // Add to cart
        $('.btn-cart').click(function(e) {
            e.preventDefault();
            var product_id = $(this).data('product-id');
            $.ajax({
                url: 'ajax/add_to_cart.php',
                type: 'POST',
                data: {
                    product_id: product_id,
                    quantity: 1
                },
                success: function(response) {
                    // Update cart count
                    updateCartCount();
                    // Show success message
                    alert('Product added to cart!');
                }
            });
        });

        // Add to wishlist
        $('.btn-wishlist').click(function(e) {
            e.preventDefault();
            var product_id = $(this).data('product-id');
            $.ajax({
                url: 'ajax/add_to_wishlist.php',
                type: 'POST',
                data: {
                    product_id: product_id
                },
                success: function(response) {
                    // Update wishlist count
                    updateWishlistCount();
                    // Show success message
                    alert('Product added to wishlist!');
                }
            });
        });

        // Update cart count
        function updateCartCount() {
            $.ajax({
                url: 'ajax/get_cart_count.php',
                type: 'GET',
                success: function(count) {
                    $('.cart-count').text(count);
                }
            });
        }

        // Update wishlist count
        function updateWishlistCount() {
            $.ajax({
                url: 'ajax/get_wishlist_count.php',
                type: 'GET',
                success: function(count) {
                    $('.wishlist-count').text(count);
                }
            });
        }
    });
    </script>
</body>
</html>