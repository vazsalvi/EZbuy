<?php
session_start();
include("./includes/connect.php");
include("./functions/common_function.php");

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Get Gaming category ID
$categories = $con->query('categories', ['category_title' => 'Gaming']);
$category_id = !empty($categories) ? $categories[0]['id'] : 5;

// Fetch data
$featured_products = getFeaturedProducts($con, 8);
$hot_deals = getHotDeals($con, 4);
$new_arrivals = getNewArrivals($con, 8);
$top_rated = getTopRatedProducts($con, 4);
$brands = getBrandsByCategory($con, $category_id);

// Gaming platforms
$platforms = [
    [
        'id' => 'pc',
        'name' => 'PC Gaming',
        'icon' => 'icon-desktop',
        'image' => 'assets/images/demos-img/pc-gaming.jpg',
        'description' => 'Ultimate gaming experience with high-end graphics'
    ],
    [
        'id' => 'playstation',
        'name' => 'PlayStation',
        'icon' => 'icon-gamepad',
        'image' => 'assets/images/demos-img/playstation.jpg',
        'description' => 'Exclusive titles and immersive gameplay'
    ],
    [
        'id' => 'xbox',
        'name' => 'Xbox',
        'icon' => 'icon-play',
        'image' => 'assets/images/demos-img/xbox.jpg',
        'description' => 'Next-gen gaming with Game Pass'
    ],
    [
        'id' => 'nintendo',
        'name' => 'Nintendo',
        'icon' => 'icon-star',
        'image' => 'assets/images/demos-img/nintendo.jpg',
        'description' => 'Family-friendly gaming on the go'
    ]
];

// Pre-orders
$preorders = [
    [
        'title' => 'Upcoming RPG Adventure',
        'release_date' => '2024-06-15',
        'image' => 'assets/images/demos-img/game-preorder-1.jpg',
        'price' => 59.99
    ],
    [
        'title' => 'Space Combat Simulator',
        'release_date' => '2024-07-01',
        'image' => 'assets/images/demos-img/game-preorder-2.jpg',
        'price' => 49.99
    ],
    [
        'title' => 'Fantasy Strategy Game',
        'release_date' => '2024-08-30',
        'image' => 'assets/images/demos-img/game-preorder-3.jpg',
        'price' => 54.99
    ]
];

// Gaming news
$news = [
    [
        'title' => 'Next-Gen Console Announcement',
        'date' => '2024-04-05',
        'image' => 'assets/images/demos-img/gaming-news-1.jpg',
        'excerpt' => 'Major gaming company reveals their upcoming console specifications'
    ],
    [
        'title' => 'Esports Tournament Results',
        'date' => '2024-04-04',
        'image' => 'assets/images/demos-img/gaming-news-2.jpg',
        'excerpt' => 'Global championship concludes with surprising winners'
    ],
    [
        'title' => 'Game Developer Conference Highlights',
        'date' => '2024-04-03',
        'image' => 'assets/images/demos-img/gaming-news-3.jpg',
        'excerpt' => 'Latest gaming technology and upcoming releases revealed'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EZbuy - Gaming Zone</title>
    <meta name="description" content="Your ultimate gaming destination">
    
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
    <link rel="stylesheet" href="assets/css/skins/skin-demo-19.css">
    <link rel="stylesheet" href="assets/css/demos/demo-19.css">
    <link rel="stylesheet" href="assets/css/chatbot.css">

    <style>
        .platform-card {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            margin-bottom: 30px;
            background: #1a1a1a;
            color: white;
            transition: transform 0.3s ease;
        }

        .platform-card:hover {
            transform: translateY(-10px);
        }

        .platform-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            opacity: 0.7;
        }

        .platform-content {
            padding: 20px;
        }

        .platform-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .preorder-card {
            background: #2a2a2a;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            color: white;
        }

        .preorder-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .release-date {
            color: var(--primary-color);
            font-weight: 600;
        }

        .news-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .news-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .news-content {
            padding: 20px;
        }

        .news-date {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .game-category {
            display: inline-block;
            padding: 5px 15px;
            margin: 5px;
            border-radius: 20px;
            background: #333;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .game-category:hover,
        .game-category.active {
            background: var(--primary-color);
        }

        body {
            background: #121212;
            color: white;
        }

        .section-title {
            color: white;
            text-align: center;
            margin-bottom: 40px;
            font-size: 2.5rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .product {
            background: #1a1a1a;
            border-radius: 10px;
            overflow: hidden;
        }

        .product-title a {
            color: white;
        }

        .product-price {
            color: var(--primary-color);
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <?php include("./includes/header.php")?>

        <main class="main">
            <!-- Hero Section -->
            <div class="intro-slider-container">
                <div class="owl-carousel owl-simple owl-dark owl-nav-inside" data-toggle="owl" data-owl-options='{
                    "nav": false,
                    "dots": true,
                    "responsive": {
                        "992": {
                            "nav": true
                        }
                    }
                }'>
                    <div class="intro-slide" style="background-image: url(assets/images/demos-img/gaming-hero.jpg);">
                        <div class="container intro-content text-center">
                            <h3 class="intro-subtitle">Level Up Your Game</h3>
                            <h1 class="intro-title">Gaming Gear & More<br>Up to 50% Off</h1>
                            <a href="#featured" class="btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gaming Platforms -->
            <div class="container">
                <h2 class="section-title">Gaming Platforms</h2>
                <div class="row">
                    <?php foreach($platforms as $platform): ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="platform-card">
                                <img src="<?php echo $platform['image']; ?>" alt="<?php echo $platform['name']; ?>">
                                <div class="platform-content">
                                    <div class="platform-icon">
                                        <i class="<?php echo $platform['icon']; ?>"></i>
                                    </div>
                                    <h3><?php echo $platform['name']; ?></h3>
                                    <p><?php echo $platform['description']; ?></p>
                                    <a href="#" class="btn btn-outline-primary">Explore</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Pre-orders -->
            <div class="container">
                <h2 class="section-title">Pre-orders</h2>
                <div class="row">
                    <?php foreach($preorders as $preorder): ?>
                        <div class="col-md-4">
                            <div class="preorder-card">
                                <img src="<?php echo $preorder['image']; ?>" alt="<?php echo $preorder['title']; ?>">
                                <h3><?php echo $preorder['title']; ?></h3>
                                <p class="release-date">Release Date: <?php echo date('F j, Y', strtotime($preorder['release_date'])); ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price"><?php echo formatPrice($preorder['price']); ?></span>
                                    <a href="#" class="btn btn-primary">Pre-order Now</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Featured Products -->
            <div id="featured" class="container">
                <h2 class="section-title">Featured Products</h2>
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
                                            <a href="#">Gaming</a>
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

            <!-- Gaming News -->
            <div class="container">
                <h2 class="section-title">Latest Gaming News</h2>
                <div class="row">
                    <?php foreach($news as $article): ?>
                        <div class="col-md-4">
                            <div class="news-card">
                                <img src="<?php echo $article['image']; ?>" alt="<?php echo $article['title']; ?>">
                                <div class="news-content">
                                    <p class="news-date"><?php echo $article['date']; ?></p>
                                    <h3><?php echo $article['title']; ?></h3>
                                    <p><?php echo $article['excerpt']; ?></p>
                                    <a href="#" class="btn btn-link">Read More</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
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
    <script src="assets/js/demos/demo-19.js"></script><script>
    $(document).ready(function() {
        // Game category toggle
        $('.game-category').click(function() {
            $(this).toggleClass('active');
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
