<?php
session_start();
include("./includes/connect.php");
include("./functions/common_function.php");

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Get Furniture category ID
$categories = $con->query('categories', ['category_title' => 'Furniture']);
$category_id = !empty($categories) ? $categories[0]['id'] : 3;

// Fetch data
$featured_products = getFeaturedProducts($con, 8);
$hot_deals = getHotDeals($con, 4);
$new_arrivals = getNewArrivals($con, 8);
$top_rated = getTopRatedProducts($con, 4);
$brands = getBrandsByCategory($con, $category_id);

// Room categories
$room_categories = [
    ['id' => 'living', 'name' => 'Living Room', 'icon' => 'icon-sofa', 'image' => 'assets/images/demos-img/living-room.jpg'],
    ['id' => 'bedroom', 'name' => 'Bedroom', 'icon' => 'icon-bed', 'image' => 'assets/images/demos-img/bedroom.jpg'],
    ['id' => 'dining', 'name' => 'Dining Room', 'icon' => 'icon-dining', 'image' => 'assets/images/demos-img/dining-room.jpg'],
    ['id' => 'office', 'name' => 'Home Office', 'icon' => 'icon-desk', 'image' => 'assets/images/demos-img/home-office.jpg']
];

// Style categories
$style_categories = [
    'Modern', 'Traditional', 'Contemporary', 'Industrial', 'Scandinavian', 'Rustic'
];

// Materials
$materials = [
    'Wood', 'Metal', 'Glass', 'Leather', 'Fabric', 'Marble'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EZbuy - Furniture Store</title>
    <meta name="description" content="Modern furniture and home decor essentials">
    
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
    <link rel="stylesheet" href="assets/css/skins/skin-demo-11.css">
    <link rel="stylesheet" href="assets/css/demos/demo-11.css">
    <link rel="stylesheet" href="assets/css/chatbot.css">

    <style>
        .room-category {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }

        .room-category:hover {
            transform: translateY(-10px);
        }

        .room-category img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .room-category-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            color: white;
        }

        .style-filter {
            display: inline-block;
            padding: 8px 15px;
            margin: 5px;
            border: 1px solid #ddd;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .style-filter:hover,
        .style-filter.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .material-filter {
            display: inline-block;
            padding: 5px 12px;
            margin: 3px;
            background: #f8f9fa;
            border-radius: 15px;
            font-size: 0.9em;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .material-filter:hover,
        .material-filter.active {
            background: var(--primary-color);
            color: white;
        }

        .room-visualizer {
            background: #f8f9fa;
            padding: 40px 0;
            margin: 40px 0;
        }

        .color-swatch {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-block;
            margin: 0 5px;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .color-swatch:hover,
        .color-swatch.active {
            border-color: var(--primary-color);
        }
    </style>
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
                    <div class="intro-slide" style="background-image: url(assets/images/demos-img/furniture-hero.jpg);">
                        <div class="container intro-content text-center">
                            <h3 class="intro-subtitle">New Collection</h3>
                            <h1 class="intro-title">Transform Your Space<br>Up to 60% Off</h1>
                            <a href="#hot-deals" class="btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room Categories -->
            <div class="container">
                <h2 class="title text-center mb-4">Shop by Room</h2>
                <div class="row">
                    <?php foreach($room_categories as $room): ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="room-category">
                                <img src="<?php echo $room['image']; ?>" alt="<?php echo $room['name']; ?>">
                                <div class="room-category-content">
                                    <h3><?php echo $room['name']; ?></h3>
                                    <a href="#" class="btn btn-outline-white">Explore</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Style Filters -->
            <div class="container text-center">
                <h2 class="title mb-4">Shop by Style</h2>
                <div class="style-filters mb-5">
                    <?php foreach($style_categories as $style): ?>
                        <span class="style-filter"><?php echo $style; ?></span>
                    <?php endforeach; ?>
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
                                            <a href="#">Furniture</a>
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

            <!-- Room Visualizer -->
            <div class="room-visualizer">
                <div class="container">
                    <h2 class="title text-center mb-4">Room Visualizer</h2>
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="visualizer-preview">
                                <img src="assets/images/demos-img/room-preview.jpg" alt="Room Preview" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="visualizer-controls">
                                <h4>Wall Color</h4>
                                <div class="color-swatches mb-4">
                                    <span class="color-swatch" style="background-color: #FFFFFF;"></span>
                                    <span class="color-swatch" style="background-color: #F5F5DC;"></span>
                                    <span class="color-swatch" style="background-color: #87CEEB;"></span>
                                    <span class="color-swatch" style="background-color: #98FB98;"></span>
                                    <span class="color-swatch" style="background-color: #DDA0DD;"></span>
                                </div>
                                <h4>Materials</h4>
                                <div class="material-filters mb-4">
                                    <?php foreach($materials as $material): ?>
                                        <span class="material-filter"><?php echo $material; ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <button class="btn btn-primary btn-block">Save Design</button>
                            </div>
                        </div>
                    </div>
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

            <!-- Design Tips -->
            <div class="container">
                <h2 class="title text-center mb-4">Design Tips & Inspiration</h2>
                <div class="row">
                    <div class="col-md-4">
                        <article class="entry">
                            <figure class="entry-media">
                                <a href="#">
                                    <img src="assets/images/demos-img/design-tip-1.jpg" alt="Design Tip 1">
                                </a>
                            </figure>
                            <div class="entry-body">
                                <h3 class="entry-title">
                                    <a href="#">How to Mix and Match Furniture Styles</a>
                                </h3>
                                <div class="entry-content">
                                    <p>Learn the art of combining different furniture styles to create a unique and harmonious space.</p>
                                    <a href="#" class="read-more">Read More</a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-4">
                        <article class="entry">
                            <figure class="entry-media">
                                <a href="#">
                                    <img src="assets/images/demos-img/design-tip-2.jpg" alt="Design Tip 2">
                                </a>
                            </figure>
                            <div class="entry-body">
                                <h3 class="entry-title">
                                    <a href="#">Small Space Solutions</a>
                                </h3>
                                <div class="entry-content">
                                    <p>Discover clever furniture arrangements and multi-functional pieces for compact living.</p>
                                    <a href="#" class="read-more">Read More</a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-4">
                        <article class="entry">
                            <figure class="entry-media">
                                <a href="#">
                                    <img src="assets/images/demos-img/design-tip-3.jpg" alt="Design Tip 3">
                                </a>
                            </figure>
                            <div class="entry-body">
                                <h3 class="entry-title">
                                    <a href="#">Color Theory in Interior Design</a>
                                </h3>
                                <div class="entry-content">
                                    <p>Master the basics of color combinations to create the perfect mood in your space.</p>
                                    <a href="#" class="read-more">Read More</a>
                                </div>
                            </div>
                        </article>
                    </div>
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
    <script src="assets/js/demos/demo-11.js"></script><script>
    $(document).ready(function() {
        // Style filter toggle
        $('.style-filter').click(function() {
            $(this).toggleClass('active');
        });

        // Material filter toggle
        $('.material-filter').click(function() {
            $(this).toggleClass('active');
        });

        // Color swatch selection
        $('.color-swatch').click(function() {
            $('.color-swatch').removeClass('active');
            $(this).addClass('active');
        });

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