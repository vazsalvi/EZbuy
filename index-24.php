<?php
session_start();
include("./includes/connect.php");
include("./functions/common_function.php");

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Get Extreme Sports category ID
$categories = $con->query('categories', ['category_title' => 'Extreme Sports']);
$category_id = !empty($categories) ? $categories[0]['id'] : 8;

// Fetch data
$featured_products = getFeaturedProducts($con, 8);
$hot_deals = getHotDeals($con, 4);
$new_arrivals = getNewArrivals($con, 8);
$top_rated = getTopRatedProducts($con, 4);
$brands = getBrandsByCategory($con, $category_id);

// Adventure categories
$adventures = [
    [
        'id' => 'skateboarding',
        'name' => 'Skateboarding',
        'icon' => 'fas fa-skateboard',
        'image' => 'https://source.unsplash.com/800x600/?skateboarding',
        'gear' => ['Decks', 'Trucks', 'Wheels', 'Protective Gear'],
        'skill_levels' => ['Beginner', 'Intermediate', 'Advanced']
    ],
    [
        'id' => 'surfing',
        'name' => 'Surfing',
        'icon' => 'fas fa-water',
        'image' => 'https://source.unsplash.com/800x600/?surfing',
        'gear' => ['Surfboards', 'Wetsuits', 'Leashes', 'Wax'],
        'skill_levels' => ['Beginner', 'Intermediate', 'Pro']
    ],
    [
        'id' => 'rockclimbing',
        'name' => 'Rock Climbing',
        'icon' => 'fas fa-mountain',
        'image' => 'https://source.unsplash.com/800x600/?rock-climbing',
        'gear' => ['Ropes', 'Harnesses', 'Carabiners', 'Shoes'],
        'skill_levels' => ['Indoor', 'Outdoor', 'Advanced']
    ],
    [
        'id' => 'snowboarding',
        'name' => 'Snowboarding',
        'icon' => 'fas fa-snowflake',
        'image' => 'https://source.unsplash.com/800x600/?snowboarding',
        'gear' => ['Boards', 'Boots', 'Bindings', 'Outerwear'],
        'skill_levels' => ['Beginner', 'Intermediate', 'Expert']
    ]
];

// Safety guides
$safety_guides = [
    [
        'title' => 'Skateboarding Safety',
        'image' => 'https://source.unsplash.com/800x600/?skateboard-safety',
        'essential_gear' => ['Helmet', 'Knee Pads', 'Elbow Pads', 'Wrist Guards'],
        'tips' => [
            'Always wear protective gear',
            'Check equipment before riding',
            'Start in safe areas',
            'Learn proper falling techniques'
        ]
    ],
    [
        'title' => 'Surfing Safety',
        'image' => 'https://source.unsplash.com/800x600/?surf-safety',
        'essential_gear' => ['Wetsuit', 'Leash', 'Sun Protection', 'First Aid Kit'],
        'tips' => [
            'Check weather conditions',
            'Never surf alone',
            'Know your limits',
            'Learn about rip currents'
        ]
    ],
    [
        'title' => 'Climbing Safety',
        'image' => 'https://source.unsplash.com/800x600/?climbing-safety',
        'essential_gear' => ['Helmet', 'Harness', 'Ropes', 'Carabiners'],
        'tips' => [
            'Double-check equipment',
            'Use proper belay techniques',
            'Communicate with partner',
            'Know rescue procedures'
        ]
    ]
];

// Adventure locations
$locations = [
    [
        'name' => 'Skate Parks',
        'type' => 'Skateboarding',
        'image' => 'https://source.unsplash.com/800x600/?skatepark',
        'features' => ['Ramps', 'Rails', 'Half-pipe', 'Street Section'],
        'difficulty' => 'Various',
        'recommended_gear' => ['Complete Skateboard', 'Safety Gear', 'Spare Parts']
    ],
    [
        'name' => 'Surf Spots',
        'type' => 'Surfing',
        'image' => 'https://source.unsplash.com/800x600/?surf-spot',
        'features' => ['Beach Break', 'Point Break', 'Reef Break'],
        'difficulty' => 'Intermediate',
        'recommended_gear' => ['Surfboard', 'Wetsuit', 'Leash']
    ],
    [
        'name' => 'Climbing Routes',
        'type' => 'Rock Climbing',
        'image' => 'https://source.unsplash.com/800x600/?climbing-route',
        'features' => ['Sport Routes', 'Bouldering', 'Top Rope'],
        'difficulty' => 'Various',
        'recommended_gear' => ['Ropes', 'Harness', 'Climbing Shoes']
    ]
];

// Skill level guides
$skill_guides = [
    [
        'level' => 'Beginner',
        'description' => 'Just starting out? Here\'s what you need',
        'recommended_gear' => [
            'Basic protective equipment',
            'Entry-level gear',
            'Learning tools'
        ],
        'tips' => [
            'Start with the basics',
            'Focus on safety',
            'Take lessons',
            'Practice regularly'
        ]
    ],
    [
        'level' => 'Intermediate',
        'description' => 'Ready to take it to the next level',
        'recommended_gear' => [
            'Quality equipment',
            'Specialized gear',
            'Performance accessories'
        ],
        'tips' => [
            'Master advanced techniques',
            'Upgrade equipment',
            'Join communities',
            'Challenge yourself'
        ]
    ],
    [
        'level' => 'Advanced',
        'description' => 'For the serious enthusiast',
        'recommended_gear' => [
            'Professional equipment',
            'High-performance gear',
            'Specialized tools'
        ],
        'tips' => [
            'Focus on style',
            'Compete in events',
            'Mentor others',
            'Push boundaries safely'
        ]
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EZbuy - Extreme Sports</title>
    <meta name="description" content="Your ultimate extreme sports gear destination">
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/icons/favicon-16x16.png">
    
    <!-- CSS Files -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/skins/skin-demo-24.css">
    <link rel="stylesheet" href="assets/css/demos/demo-24.css">
    <link rel="stylesheet" href="assets/css/chatbot.css">

    <style>
        body {
            background: #121212;
            color: white;
        }

        .adventure-card {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            margin-bottom: 30px;
            background: #1a1a1a;
            transition: transform 0.3s ease;
        }

        .adventure-card:hover {
            transform: translateY(-10px);
        }

        .adventure-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            opacity: 0.8;
        }

        .adventure-content {
            padding: 20px;
            color: white;
        }

        .adventure-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .gear-list {
            list-style: none;
            padding: 0;
            margin: 10px 0;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .gear-list li {
            background: #333;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9em;
            color: white;
        }

        .skill-level {
            display: inline-block;
            padding: 5px 15px;
            margin: 5px;
            border-radius: 20px;
            font-size: 0.9em;
            background: var(--primary-color);
            color: white;
        }

        .safety-card {
            background: #1a1a1a;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .safety-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .safety-content {
            padding: 20px;
            color: white;
        }

        .safety-tips {
            list-style: none;
            padding: 0;
            margin: 10px 0;
        }

        .safety-tips li {
            padding: 8px 0;
            border-bottom: 1px solid #333;
        }

        .safety-tips li:last-child {
            border-bottom: none;
        }

        .location-card {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .location-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .location-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
            color: white;
        }

        .skill-guide-card {
            background: #1a1a1a;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            color: white;
        }

        .skill-guide-card h3 {
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .skill-tips {
            list-style: none;
            padding: 0;
            margin: 10px 0;
        }

        .skill-tips li {
            padding: 5px 0;
            display: flex;
            align-items: center;
        }

        .skill-tips li:before {
            content: '→';
            margin-right: 10px;
            color: var(--primary-color);
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
                <div class="owl-carousel owl-simple owl-light owl-nav-inside" data-toggle="owl" data-owl-options='{
                    "nav": false,
                    "dots": true,
                    "responsive": {
                        "992": {
                            "nav": true
                        }
                    }
                }'>
                    <div class="intro-slide" style="background-image: url(https://source.unsplash.com/1600x900/?extreme-sports);">
                        <div class="container intro-content text-center">
                            <h3 class="intro-subtitle">Push Your Limits</h3>
                            <h1 class="intro-title">Extreme Sports Gear<br>Up to 40% Off</h1>
                            <a href="#featured" class="btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Adventure Categories -->
            <div class="container">
                <h2 class="section-title">Choose Your Adventure</h2>
                <div class="row">
                    <?php foreach($adventures as $adventure): ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="adventure-card">
                                <img src="<?php echo $adventure['image']; ?>" alt="<?php echo $adventure['name']; ?>">
                                <div class="adventure-content">
                                    <div class="adventure-icon">
                                        <i class="<?php echo $adventure['icon']; ?>"></i>
                                    </div>
                                    <h3><?php echo $adventure['name']; ?></h3>
                                    <ul class="gear-list">
                                        <?php foreach($adventure['gear'] as $item): ?>
                                            <li><?php echo $item; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <div class="skill-levels">
                                        <?php foreach($adventure['skill_levels'] as $level): ?>
                                            <span class="skill-level"><?php echo $level; ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Safety Guides -->
            <div class="container">
                <h2 class="section-title">Safety First</h2>
                <div class="row">
                    <?php foreach($safety_guides as $guide): ?>
                        <div class="col-md-4">
                            <div class="safety-card">
                                <img src="<?php echo $guide['image']; ?>" alt="<?php echo $guide['title']; ?>">
                                <div class="safety-content">
                                    <h3><?php echo $guide['title']; ?></h3>
                                    <h4>Essential Gear:</h4>
                                    <ul class="gear-list">
                                        <?php foreach($guide['essential_gear'] as $gear): ?>
                                            <li><?php echo $gear; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <h4>Safety Tips:</h4>
                                    <ul class="safety-tips">
                                        <?php foreach($guide['tips'] as $tip): ?>
                                            <li><?php echo $tip; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Featured Products -->
            <div id="featured" class="container">
                <h2 class="section-title">Featured Gear</h2>
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
                                            <a href="#">Extreme Sports</a>
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

            <!-- Adventure Locations -->
            <div class="container">
                <h2 class="section-title">Adventure Spots</h2>
                <div class="row">
                    <?php foreach($locations as $location): ?>
                        <div class="col-md-4">
                            <div class="location-card">
                                <img src="<?php echo $location['image']; ?>" alt="<?php echo $location['name']; ?>">
                                <div class="location-content">
                                    <span class="type"><?php echo $location['type']; ?></span>
                                    <h3><?php echo $location['name']; ?></h3>
                                    <div class="features">
                                        <h4>Features:</h4>
                                        <ul class="list-unstyled">
                                            <?php foreach($location['features'] as $feature): ?>
                                                <li><?php echo $feature; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                    <p class="difficulty">Difficulty: <?php echo $location['difficulty']; ?></p>
                                    <div class="gear">
                                        <h4>Recommended Gear:</h4>
                                        <ul class="gear-list">
                                            <?php foreach($location['recommended_gear'] as $gear): ?>
                                                <li><?php echo $gear; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Skill Level Guides -->
            <div class="container">
                <h2 class="section-title">Skill Level Guides</h2>
                <div class="row">
                    <?php foreach($skill_guides as $guide): ?>
                        <div class="col-md-4">
                            <div class="skill-guide-card">
                                <h3><?php echo $guide['level']; ?></h3>
                                <p><?php echo $guide['description']; ?></p>
                                <h4>Recommended Gear:</h4>
                                <ul class="skill-tips">
                                    <?php foreach($guide['recommended_gear'] as $gear): ?>
                                        <li><?php echo $gear; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <h4>Tips:</h4>
                                <ul class="skill-tips">
                                    <?php foreach($guide['tips'] as $tip): ?>
                                        <li><?php echo $tip; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </main>

        <?php include("./includes/footer.php")?>
    </div>

    <button id="scroll-top" title="Back to Top"><i class="fas fa-arrow-up"></i></button>

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div>
    <div class="mobile-menu-container"></div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/demos/demo-24.js"></script><script>
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