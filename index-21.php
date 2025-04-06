<?php
session_start();
include("./includes/connect.php");
include("./functions/common_function.php");

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Get Sports category ID
$categories = $con->query('categories', ['category_title' => 'Sports']);
$category_id = !empty($categories) ? $categories[0]['id'] : 7;

// Fetch data
$featured_products = getFeaturedProducts($con, 8);
$hot_deals = getHotDeals($con, 4);
$new_arrivals = getNewArrivals($con, 8);
$top_rated = getTopRatedProducts($con, 4);
$brands = getBrandsByCategory($con, $category_id);

// Sports categories
$sports = [
    [
        'id' => 'basketball',
        'name' => 'Basketball',
        'icon' => 'icon-basketball',
        'image' => 'assets/images/demos-img/basketball.jpg',
        'equipment' => ['Balls', 'Shoes', 'Jerseys', 'Hoops']
    ],
    [
        'id' => 'football',
        'name' => 'Football',
        'icon' => 'icon-football',
        'image' => 'assets/images/demos-img/football.jpg',
        'equipment' => ['Balls', 'Cleats', 'Protective Gear', 'Goals']
    ],
    [
        'id' => 'cricket',
        'name' => 'Cricket',
        'icon' => 'icon-cricket',
        'image' => 'assets/images/demos-img/cricket.jpg',
        'equipment' => ['Bats', 'Balls', 'Protective Gear', 'Stumps']
    ],
    [
        'id' => 'tennis',
        'name' => 'Tennis',
        'icon' => 'icon-tennis',
        'image' => 'assets/images/demos-img/tennis.jpg',
        'equipment' => ['Rackets', 'Balls', 'Shoes', 'Nets']
    ]
];

// Equipment guides
$guides = [
    [
        'title' => 'Choosing the Right Basketball',
        'image' => 'assets/images/demos-img/basketball-guide.jpg',
        'tips' => [
            'Consider the playing surface',
            'Check the size and weight',
            'Look for grip quality',
            'Indoor vs outdoor use'
        ]
    ],
    [
        'title' => 'Football Cleat Selection',
        'image' => 'assets/images/demos-img/football-guide.jpg',
        'tips' => [
            'Position-specific features',
            'Field type considerations',
            'Proper fit guidelines',
            'Maintenance tips'
        ]
    ],
    [
        'title' => 'Cricket Bat Guide',
        'image' => 'assets/images/demos-img/cricket-guide.jpg',
        'tips' => [
            'Weight and balance',
            'Wood quality',
            'Handle type',
            'Size selection'
        ]
    ]
];

// Training tips
$training_tips = [
    [
        'title' => 'Basketball Drills',
        'category' => 'Basketball',
        'image' => 'assets/images/demos-img/basketball-training.jpg',
        'tips' => [
            'Dribbling exercises',
            'Shooting practice',
            'Defense techniques',
            'Team plays'
        ]
    ],
    [
        'title' => 'Football Training',
        'category' => 'Football',
        'image' => 'assets/images/demos-img/football-training.jpg',
        'tips' => [
            'Ball control drills',
            'Passing accuracy',
            'Speed training',
            'Team formations'
        ]
    ],
    [
        'title' => 'Cricket Practice',
        'category' => 'Cricket',
        'image' => 'assets/images/demos-img/cricket-training.jpg',
        'tips' => [
            'Batting technique',
            'Bowling practice',
            'Fielding drills',
            'Match strategy'
        ]
    ]
];

// Team gear
$team_gear = [
    [
        'team' => 'Local Champions',
        'sport' => 'Basketball',
        'image' => 'assets/images/demos-img/basketball-team.jpg',
        'items' => ['Jersey', 'Shorts', 'Socks', 'Warmup Jacket']
    ],
    [
        'team' => 'City United',
        'sport' => 'Football',
        'image' => 'assets/images/demos-img/football-team.jpg',
        'items' => ['Home Kit', 'Away Kit', 'Training Kit', 'Accessories']
    ],
    [
        'team' => 'Regional Stars',
        'sport' => 'Cricket',
        'image' => 'assets/images/demos-img/cricket-team.jpg',
        'items' => ['Match Kit', 'Practice Kit', 'Caps', 'Equipment Bag']
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EZbuy - Sports Central</title>
    <meta name="description" content="Your ultimate sports equipment destination">
    
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
    <link rel="stylesheet" href="assets/css/skins/skin-demo-21.css">
    <link rel="stylesheet" href="assets/css/demos/demo-21.css">
    <link rel="stylesheet" href="assets/css/chatbot.css">

    <style>
        .sport-card {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            margin-bottom: 30px;
            background: #f8f9fa;
            transition: transform 0.3s ease;
        }

        .sport-card:hover {
            transform: translateY(-10px);
        }

        .sport-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .sport-content {
            padding: 20px;
        }

        .sport-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .equipment-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .equipment-list li {
            display: inline-block;
            padding: 5px 10px;
            margin: 3px;
            background: #e9ecef;
            border-radius: 15px;
            font-size: 0.9em;
        }

        .guide-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .guide-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .guide-content {
            padding: 20px;
        }

        .tip-list {
            list-style: none;
            padding: 0;
            margin: 10px 0;
        }

        .tip-list li {
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }

        .tip-list li:last-child {
            border-bottom: none;
        }

        .training-card {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .training-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .training-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            color: white;
        }

        .team-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .team-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .team-info {
            padding: 20px;
        }

        .team-items {
            list-style: none;
            padding: 0;
            margin: 10px 0;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .team-items li {
            background: #f8f9fa;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9em;
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
                    <div class="intro-slide" style="background-image: url(assets/images/demos-img/sports-hero.jpg);">
                        <div class="container intro-content text-center">
                            <h3 class="intro-subtitle">Get in the Game</h3>
                            <h1 class="intro-title">Sports Equipment<br>Up to 50% Off</h1>
                            <a href="#featured" class="btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sports Categories -->
            <div class="container">
                <h2 class="title text-center mb-4">Shop by Sport</h2>
                <div class="row">
                    <?php foreach($sports as $sport): ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="sport-card">
                                <img src="<?php echo $sport['image']; ?>" alt="<?php echo $sport['name']; ?>">
                                <div class="sport-content">
                                    <div class="sport-icon">
                                        <i class="<?php echo $sport['icon']; ?>"></i>
                                    </div>
                                    <h3><?php echo $sport['name']; ?></h3>
                                    <ul class="equipment-list">
                                        <?php foreach($sport['equipment'] as $item): ?>
                                            <li><?php echo $item; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Equipment Guides -->
            <div class="container">
                <h2 class="title text-center mb-4">Equipment Guides</h2>
                <div class="row">
                    <?php foreach($guides as $guide): ?>
                        <div class="col-md-4">
                            <div class="guide-card">
                                <img src="<?php echo $guide['image']; ?>" alt="<?php echo $guide['title']; ?>">
                                <div class="guide-content">
                                    <h3><?php echo $guide['title']; ?></h3>
                                    <ul class="tip-list">
                                        <?php foreach($guide['tips'] as $tip): ?>
                                            <li><?php echo $tip; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <a href="#" class="btn btn-outline-primary">Read More</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Featured Products -->
            <div id="featured" class="container">
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
                                            <a href="#">Sports</a>
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

            <!-- Training Tips -->
            <div class="container">
                <h2 class="title text-center mb-4">Training Tips</h2>
                <div class="row">
                    <?php foreach($training_tips as $tip): ?>
                        <div class="col-md-4">
                            <div class="training-card">
                                <img src="<?php echo $tip['image']; ?>" alt="<?php echo $tip['title']; ?>">
                                <div class="training-content">
                                    <span class="category"><?php echo $tip['category']; ?></span>
                                    <h3><?php echo $tip['title']; ?></h3>
                                    <ul class="list-unstyled">
                                        <?php foreach($tip['tips'] as $item): ?>
                                            <li><?php echo $item; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <a href="#" class="btn btn-outline-white">Learn More</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Team Gear -->
            <div class="container">
                <h2 class="title text-center mb-4">Team Gear</h2>
                <div class="row">
                    <?php foreach($team_gear as $team): ?>
                        <div class="col-md-4">
                            <div class="team-card">
                                <img src="<?php echo $team['image']; ?>" alt="<?php echo $team['team']; ?>">
                                <div class="team-info">
                                    <span class="sport"><?php echo $team['sport']; ?></span>
                                    <h3><?php echo $team['team']; ?></h3>
                                    <ul class="team-items">
                                        <?php foreach($team['items'] as $item): ?>
                                            <li><?php echo $item; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <a href="#" class="btn btn-primary">Shop Collection</a>
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
    <script src="assets/js/demos/demo-21.js"></script><script>
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
