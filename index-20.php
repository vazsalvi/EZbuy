<?php
session_start();
include("./includes/connect.php");
include("./functions/common_function.php");

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Get Books category ID
$categories = $con->query('categories', ['category_title' => 'Books']);
$category_id = !empty($categories) ? $categories[0]['id'] : 6;

// Fetch data
$featured_products = getFeaturedProducts($con, 8);
$hot_deals = getHotDeals($con, 4);
$new_arrivals = getNewArrivals($con, 8);
$top_rated = getTopRatedProducts($con, 4);
$brands = getBrandsByCategory($con, $category_id);

// Book genres
$genres = [
    [
        'id' => 'fiction',
        'name' => 'Fiction',
        'icon' => 'icon-book',
        'subgenres' => ['Literary', 'Mystery', 'Science Fiction', 'Fantasy']
    ],
    [
        'id' => 'nonfiction',
        'name' => 'Non-Fiction',
        'icon' => 'icon-book',
        'subgenres' => ['Biography', 'History', 'Science', 'Self-Help']
    ],
    [
        'id' => 'academic',
        'name' => 'Academic',
        'icon' => 'icon-graduation',
        'subgenres' => ['Textbooks', 'Research', 'Reference']
    ],
    [
        'id' => 'children',
        'name' => "Children's",
        'icon' => 'icon-star',
        'subgenres' => ['Picture Books', 'Middle Grade', 'Young Adult']
    ]
];

// Featured authors
$authors = [
    [
        'name' => 'Jane Smith',
        'image' => 'assets/images/demos-img/author-1.jpg',
        'bio' => 'Bestselling author of contemporary fiction',
        'latest_book' => 'The Hidden Path'
    ],
    [
        'name' => 'John Doe',
        'image' => 'assets/images/demos-img/author-2.jpg',
        'bio' => 'Award-winning science fiction writer',
        'latest_book' => 'Beyond the Stars'
    ],
    [
        'name' => 'Sarah Wilson',
        'image' => 'assets/images/demos-img/author-3.jpg',
        'bio' => 'Expert in historical non-fiction',
        'latest_book' => 'Ancient Mysteries'
    ]
];

// Reading lists
$reading_lists = [
    [
        'title' => 'Summer Reading 2024',
        'description' => 'Perfect beach reads for your vacation',
        'image' => 'assets/images/demos-img/summer-reads.jpg',
        'books' => ['Beach House', 'Summer Love', 'Ocean Dreams']
    ],
    [
        'title' => 'Business Essentials',
        'description' => 'Must-read books for entrepreneurs',
        'image' => 'assets/images/demos-img/business-books.jpg',
        'books' => ['Start Up', 'Leadership 101', 'Success Habits']
    ],
    [
        'title' => 'Classic Literature',
        'description' => 'Timeless masterpieces',
        'image' => 'assets/images/demos-img/classics.jpg',
        'books' => ['Pride & Prejudice', 'Great Expectations', 'Jane Eyre']
    ]
];

// Book reviews
$reviews = [
    [
        'book_title' => 'The Hidden Path',
        'reviewer' => 'Book Lover',
        'rating' => 5,
        'review' => 'A captivating story that keeps you guessing until the end.',
        'date' => '2024-04-01'
    ],
    [
        'book_title' => 'Beyond the Stars',
        'reviewer' => 'Sci-Fi Fan',
        'rating' => 4,
        'review' => 'Innovative world-building and compelling characters.',
        'date' => '2024-04-02'
    ],
    [
        'book_title' => 'Ancient Mysteries',
        'reviewer' => 'History Buff',
        'rating' => 5,
        'review' => 'Well-researched and fascinating insights into the past.',
        'date' => '2024-04-03'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EZbuy - Book Haven</title>
    <meta name="description" content="Your ultimate destination for books">
    
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
    <link rel="stylesheet" href="assets/css/skins/skin-demo-20.css">
    <link rel="stylesheet" href="assets/css/demos/demo-20.css">
    <link rel="stylesheet" href="assets/css/chatbot.css">

    <style>
        .genre-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .genre-card:hover {
            transform: translateY(-5px);
        }

        .genre-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .subgenre-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .subgenre-list li {
            display: inline-block;
            padding: 5px 10px;
            margin: 3px;
            background: #e9ecef;
            border-radius: 15px;
            font-size: 0.9em;
        }

        .author-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .author-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .author-info {
            padding: 20px;
        }

        .reading-list-card {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .reading-list-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .reading-list-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            color: white;
        }

        .review-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .reviewer {
            color: var(--text-light);
            font-size: 0.9em;
        }

        .review-date {
            color: var(--text-light);
            font-size: 0.8em;
        }

        .book-format {
            display: inline-block;
            padding: 5px 10px;
            margin: 5px;
            border: 1px solid #ddd;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .book-format:hover,
        .book-format.active {
            background: var(--primary-color);
            color: white;
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
                    <div class="intro-slide" style="background-image: url(assets/images/demos-img/books-hero.jpg);">
                        <div class="container intro-content text-center">
                            <h3 class="intro-subtitle">Discover New Worlds</h3>
                            <h1 class="intro-title">Book Sale<br>Up to 70% Off</h1>
                            <a href="#featured" class="btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Book Genres -->
            <div class="container">
                <h2 class="title text-center mb-4">Browse by Genre</h2>
                <div class="row">
                    <?php foreach($genres as $genre): ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="genre-card">
                                <div class="genre-icon">
                                    <i class="<?php echo $genre['icon']; ?>"></i>
                                </div>
                                <h3><?php echo $genre['name']; ?></h3>
                                <ul class="subgenre-list">
                                    <?php foreach($genre['subgenres'] as $subgenre): ?>
                                        <li><?php echo $subgenre; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Featured Authors -->
            <div class="container">
                <h2 class="title text-center mb-4">Featured Authors</h2>
                <div class="row">
                    <?php foreach($authors as $author): ?>
                        <div class="col-md-4">
                            <div class="author-card">
                                <img src="<?php echo $author['image']; ?>" alt="<?php echo $author['name']; ?>">
                                <div class="author-info">
                                    <h3><?php echo $author['name']; ?></h3>
                                    <p><?php echo $author['bio']; ?></p>
                                    <p><strong>Latest Book:</strong> <?php echo $author['latest_book']; ?></p>
                                    <a href="#" class="btn btn-outline-primary">View Books</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Featured Products -->
            <div id="featured" class="container">
                <h2 class="title text-center mb-4">Featured Books</h2>
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
                                            <a href="#">Books</a>
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

            <!-- Reading Lists -->
            <div class="container">
                <h2 class="title text-center mb-4">Curated Reading Lists</h2>
                <div class="row">
                    <?php foreach($reading_lists as $list): ?>
                        <div class="col-md-4">
                            <div class="reading-list-card">
                                <img src="<?php echo $list['image']; ?>" alt="<?php echo $list['title']; ?>">
                                <div class="reading-list-content">
                                    <h3><?php echo $list['title']; ?></h3>
                                    <p><?php echo $list['description']; ?></p>
                                    <ul class="list-unstyled">
                                        <?php foreach($list['books'] as $book): ?>
                                            <li><?php echo $book; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <a href="#" class="btn btn-outline-white">View List</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Book Reviews -->
            <div class="container">
                <h2 class="title text-center mb-4">Latest Reviews</h2>
                <div class="row">
                    <?php foreach($reviews as $review): ?>
                        <div class="col-md-4">
                            <div class="review-card">
                                <h3><?php echo $review['book_title']; ?></h3>
                                <p class="reviewer">By <?php echo $review['reviewer']; ?></p>
                                <div class="ratings mb-2">
                                    <?php
                                    for ($i = 0; $i < 5; $i++) {
                                        echo $i < $review['rating'] ? '<i class="icon-star"></i>' : '<i class="icon-star-o"></i>';
                                    }
                                    ?>
                                </div>
                                <p><?php echo $review['review']; ?></p>
                                <p class="review-date"><?php echo date('F j, Y', strtotime($review['date'])); ?></p>
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
    <script src="assets/js/demos/demo-20.js"></script><script>
    $(document).ready(function() {
        // Book format toggle
        $('.book-format').click(function() {
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