<?php
session_start();
include("./includes/connect.php");
include("./functions/common_function.php");

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Get Fashion category ID
$categories = $con->query('categories', ['category_title' => 'Fashion']);
$category_id = !empty($categories) ? $categories[0]['id'] : 4;

// Fetch data
$featured_products = getFeaturedProducts($con, 8);
$hot_deals = getHotDeals($con, 4);
$new_arrivals = getNewArrivals($con, 8);
$top_rated = getTopRatedProducts($con, 4);
$brands = getBrandsByCategory($con, $category_id);

// Collections
$collections = [
    [
        'id' => 'summer',
        'name' => 'Summer Collection',
        'description' => 'Light, breezy pieces for the perfect summer look',
        'image' => 'assets/images/demos-img/summer-collection.jpg'
    ],
    [
        'id' => 'autumn',
        'name' => 'Autumn Collection',
        'description' => 'Cozy and stylish for the fall season',
        'image' => 'assets/images/demos-img/autumn-collection.jpg'
    ],
    [
        'id' => 'winter',
        'name' => 'Winter Collection',
        'description' => 'Stay warm without compromising on style',
        'image' => 'assets/images/demos-img/winter-collection.jpg'
    ],
    [
        'id' => 'spring',
        'name' => 'Spring Collection',
        'description' => 'Fresh and vibrant pieces for the new season',
        'image' => 'assets/images/demos-img/spring-collection.jpg'
    ]
];

// Style categories
$styles = [
    'Casual', 'Formal', 'Bohemian', 'Streetwear', 'Vintage', 'Minimalist'
];

// Outfit combinations
$outfits = [
    [
        'name' => 'Office Ready',
        'items' => ['Blazer', 'Pencil Skirt', 'Silk Blouse', 'Pumps'],
        'image' => 'assets/images/demos-img/office-outfit.jpg'
    ],
    [
        'name' => 'Weekend Casual',
        'items' => ['Denim Jacket', 'White Tee', 'Jeans', 'Sneakers'],
        'image' => 'assets/images/demos-img/casual-outfit.jpg'
    ],
    [
        'name' => 'Evening Glam',
        'items' => ['Cocktail Dress', 'Clutch', 'Heels', 'Statement Jewelry'],
        'image' => 'assets/images/demos-img/evening-outfit.jpg'
    ],
    [
        'name' => 'Brunch Date',
        'items' => ['Floral Dress', 'Cardigan', 'Sandals', 'Crossbody Bag'],
        'image' => 'assets/images/demos-img/brunch-outfit.jpg'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EZbuy - Fashion Studio</title>
    <meta name="description" content="Contemporary clothing and accessories">
    
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
    <link rel="stylesheet" href="assets/css/skins/skin-demo-12.css">
    <link rel="stylesheet" href="assets/css/demos/demo-12.css">
    <link rel="stylesheet" href="assets/css/chatbot.css">

    <style>
        .collection-card {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            margin-bottom: 30px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .collection-card:hover {
            transform: translateY(-10px);
        }

        .collection-card img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .collection-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 30px;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            color: white;
        }

        .style-tag {
            display: inline-block;
            padding: 8px 15px;
            margin: 5px;
            border: 1px solid #ddd;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .style-tag:hover,
        .style-tag.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .outfit-card {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .outfit-card img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .outfit-details {
            position: absolute;
            bottom: -100%;
            left: 0;
            right: 0;
            padding: 20px;
            background: rgba(255,255,255,0.95);
            transition: bottom 0.3s ease;
        }

        .outfit-card:hover .outfit-details {
            bottom: 0;
        }

        .size-guide {
            background: #f8f9fa;
            padding: 40px 0;
            margin: 40px 0;
        }

        .size-table th,
        .size-table td {
            text-align: center;
            padding: 10px;
        }

        .measurement-tip {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
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
                    <div class="intro-slide" style="background-image: url(assets/images/demos-img/fashion-hero.jpg);">
                        <div class="container intro-content text-center">
                            <h3 class="intro-subtitle">New Season</h3>
                            <h1 class="intro-title">Discover Your Style<br>Up to 70% Off</h1>
                            <a href="#collections" class="btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seasonal Collections -->
            <div id="collections" class="container">
                <h2 class="title text-center mb-4">Seasonal Collections</h2>
                <div class="row">
                    <?php foreach($collections as $collection): ?>
                        <div class="col-md-6">
                            <div class="collection-card">
                                <img src="<?php echo $collection['image']; ?>" alt="<?php echo $collection['name']; ?>">
                                <div class="collection-overlay">
                                    <h3><?php echo $collection['name']; ?></h3>
                                    <p><?php echo $collection['description']; ?></p>
                                    <a href="#" class="btn btn-outline-white">Shop Collection</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Style Categories -->
            <div class="container text-center">
                <h2 class="title mb-4">Shop by Style</h2>
                <div class="style-tags mb-5">
                    <?php foreach($styles as $style): ?>
                        <span class="style-tag"><?php echo $style; ?></span>
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
                                            <a href="#">Fashion</a>
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

            <!-- Size Guide -->
            <div class="size-guide">
                <div class="container">
                    <h2 class="title text-center mb-4">Size Guide</h2>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="table-responsive">
                                <table class="table table-striped size-table">
                                    <thead>
                                        <tr>
                                            <th>Size</th>
                                            <th>Bust (cm)</th>
                                            <th>Waist (cm)</th>
                                            <th>Hips (cm)</th>
                                            <th>US Size</th>
                                            <th>UK Size</th>
                                            <th>EU Size</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>XS</td>
                                            <td>82-85</td>
                                            <td>63-66</td>
                                            <td>89-92</td>
                                            <td>2-4</td>
                                            <td>6-8</td>
                                            <td>34-36</td>
                                        </tr>
                                        <tr>
                                            <td>S</td>
                                            <td>86-89</td>
                                            <td>67-70</td>
                                            <td>93-96</td>
                                            <td>6-8</td>
                                            <td>10-12</td>
                                            <td>38-40</td>
                                        </tr>
                                        <tr>
                                            <td>M</td>
                                            <td>90-93</td>
                                            <td>71-74</td>
                                            <td>97-100</td>
                                            <td>10-12</td>
                                            <td>14-16</td>
                                            <td>42-44</td>
                                        </tr>
                                        <tr>
                                            <td>L</td>
                                            <td>94-97</td>
                                            <td>75-78</td>
                                            <td>101-104</td>
                                            <td>14-16</td>
                                            <td>18-20</td>
                                            <td>46-48</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="measurement-tip">
                                <h4>How to Measure</h4>
                                <p>For the best fit, measure:</p>
                                <ul>
                                    <li>Bust: Around the fullest part of your bust</li>
                                    <li>Waist: Around your natural waistline</li>
                                    <li>Hips: Around the fullest part of your hips</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <img src="assets/images/demos-img/measurement-guide.jpg" alt="Measurement Guide" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Outfit Recommendations -->
            <div class="container">
                <h2 class="title text-center mb-4">Complete the Look</h2>
                <div class="row">
                    <?php foreach($outfits as $outfit): ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="outfit-card">
                                <img src="<?php echo $outfit['image']; ?>" alt="<?php echo $outfit['name']; ?>">
                                <div class="outfit-details">
                                    <h3><?php echo $outfit['name']; ?></h3>
                                    <ul class="list-unstyled">
                                        <?php foreach($outfit['items'] as $item): ?>
                                            <li><?php echo $item; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <a href="#" class="btn btn-primary">Shop This Look</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Style Tips -->
            <div class="container">
                <h2 class="title text-center mb-4">Style Tips & Trends</h2>
                <div class="row">
                    <div class="col-md-4">
                        <article class="entry">
                            <figure class="entry-media">
                                <a href="#">
                                    <img src="assets/images/demos-img/style-tip-1.jpg" alt="Style Tip 1">
                                </a>
                            </figure>
                            <div class="entry-body">
                                <h3 class="entry-title">
                                    <a href="#">10 Ways to Style a White T-Shirt</a>
                                </h3>
                                <div class="entry-content">
                                    <p>Transform this wardrobe staple into countless stylish outfits.</p>
                                    <a href="#" class="read-more">Read More</a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-4">
                        <article class="entry">
                            <figure class="entry-media">
                                <a href="#">
                                    <img src="assets/images/demos-img/style-tip-2.jpg" alt="Style Tip 2">
                                </a>
                            </figure>
                            <div class="entry-body">
                                <h3 class="entry-title">
                                    <a href="#">Building a Capsule Wardrobe</a>
                                </h3>
                                <div class="entry-content">
                                    <p>Essential pieces for a versatile and sustainable wardrobe.</p>
                                    <a href="#" class="read-more">Read More</a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-4">
                        <article class="entry">
                            <figure class="entry-media">
                                <a href="#">
                                    <img src="assets/images/demos-img/style-tip-3.jpg" alt="Style Tip 3">
                                </a>
                            </figure>
                            <div class="entry-body">
                                <h3 class="entry-title">
                                    <a href="#">Accessorizing Like a Pro</a>
                                </h3>
                                <div class="entry-content">
                                    <p>Learn how to elevate any outfit with the right accessories.</p>
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
    <script src="assets/js/demos/demo-12.js"></script><script>
    $(document).ready(function() {
        // Style tag toggle
        $('.style-tag').click(function() {
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