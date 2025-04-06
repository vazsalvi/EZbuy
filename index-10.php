<?php
session_start();
include("./includes/connect.php");
include("./functions/common_function.php");

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Get Shoes category ID
$categories = $con->query('categories', ['category_title' => 'Footwear']);
$category_id = !empty($categories) ? $categories[0]['id'] : 2;

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
    <title>EZbuy - Footwear Collection</title>
    <meta name="description" content="Trendy shoes, sneakers, and fashion footwear">
    
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
    <link rel="stylesheet" href="assets/css/skins/skin-demo-10.css">
    <link rel="stylesheet" href="assets/css/demos/demo-10.css">
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
                    <div class="intro-slide" style="background-image: url(assets/images/demos-img/shoe.jpg);">
                        <div class="container intro-content text-center">
                            <h3 class="intro-subtitle">New Collection</h3>
                            <h1 class="intro-title">Step into Style<br>Up to 70% Off</h1>
                            <a href="#hot-deals" class="btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categories Grid -->
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-lg-3">
                        <div class="banner banner-cat">
                            <a href="#">
                                <img src="assets/images/demos-img/casual.jpg" alt="Casual Shoes">
                                <div class="banner-content">
                                    <h3 class="banner-title">Casual</h3>
                                    <h4 class="banner-subtitle">Comfort First</h4>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="banner banner-cat">
                            <a href="#">
                                <img src="assets/images/demos-img/sports.jpg" alt="Sports Shoes">
                                <div class="banner-content">
                                    <h3 class="banner-title">Sports</h3>
                                    <h4 class="banner-subtitle">Performance</h4>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="banner banner-cat">
                            <a href="#">
                                <img src="assets/images/demos-img/formal.jpg" alt="Formal Shoes">
                                <div class="banner-content">
                                    <h3 class="banner-title">Formal</h3>
                                    <h4 class="banner-subtitle">Elegance</h4>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="banner banner-cat">
                            <a href="#">
                                <img src="assets/images/demos-img/boots.jpg" alt="Boots">
                                <div class="banner-content">
                                    <h3 class="banner-title">Boots</h3>
                                    <h4 class="banner-subtitle">Adventure</h4>
                                </div>
                            </a>
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
                                            <a href="#">Footwear</a>
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

            <!-- Size Guide -->
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="size-guide-container bg-light p-4 rounded">
                            <h3 class="text-center mb-4">Size Guide</h3>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>US Size</th>
                                            <th>UK Size</th>
                                            <th>EU Size</th>
                                            <th>Foot Length (cm)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>6</td>
                                            <td>5.5</td>
                                            <td>39</td>
                                            <td>23.5</td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td>6.5</td>
                                            <td>40</td>
                                            <td>24.1</td>
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td>7.5</td>
                                            <td>41</td>
                                            <td>24.7</td>
                                        </tr>
                                        <tr>
                                            <td>9</td>
                                            <td>8.5</td>
                                            <td>42</td>
                                            <td>25.4</td>
                                        </tr>
                                        <tr>
                                            <td>10</td>
                                            <td>9.5</td>
                                            <td>43</td>
                                            <td>26.0</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
    <script src="assets/js/demos/demo-10.js"></script><script>
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