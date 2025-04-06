<?php
// Keep PHP part unchanged until categories array
session_start();

if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

// Update categories array with custom icon classes
$categories = [
    [
        'id' => 'electronics',
        'title' => 'Electronics Hub',
        'icon' => 'icon-laptop',
        'description' => 'Latest gadgets, smart devices, and cutting-edge technology',
        'products' => '500+',
        'rating' => '4.8',
        'link' => 'index-4.php',
        'image' => 'assets/images/demos-img/electronics (2).jpg'
    ],
    [
        'id' => 'shoes',
        'title' => 'Footwear Collection',
        'icon' => 'icon-shopping-cart',
        'description' => 'Trendy shoes, sneakers, and fashion footwear',
        'products' => '300+',
        'rating' => '4.7',
        'link' => 'index-10.php',
        'image' => 'assets/images/demos-img/shoe.jpg'
    ],
    [
        'id' => 'furniture',
        'title' => 'Home & Furniture',
        'icon' => 'icon-th',
        'description' => 'Modern furniture and home decor essentials',
        'products' => '200+',
        'rating' => '4.9',
        'link' => 'index-11.php',
        'image' => 'assets/images/demos-img/bedroom.jpg'
    ],
    [
        'id' => 'fashion',
        'title' => 'Fashion Studio',
        'icon' => 'icon-star',
        'description' => 'Contemporary clothing and accessories',
        'products' => '1000+',
        'rating' => '4.6',
        'link' => 'index-12.php',
        'image' => 'assets/images/demos-img/traditional.jpg'
    ],
    [
        'id' => 'gaming',
        'title' => 'Gaming Zone',
        'icon' => 'icon-life-saver',
        'description' => 'Games, consoles, and gaming accessories',
        'products' => '400+',
        'rating' => '4.8',
        'link' => 'index-19.php',
        'image' => 'assets/images/demos-img/game.jpg'
    ],
    [
        'id' => 'books',
        'title' => 'Book Haven',
        'icon' => 'icon-align-left',
        'description' => 'Books across all genres and interests',
        'products' => '5000+',
        'rating' => '4.9',
        'link' => 'index-20.php',
        'image' => 'assets/images/demos-img/books (1).jpg'
    ],
    [
        'id' => 'sports',
        'title' => 'Sports Central',
        'icon' => 'icon-html5',
        'description' => 'Sports equipment and fitness gear',
        'products' => '600+',
        'rating' => '4.7',
        'link' => 'index-21.php',
        'image' => 'assets/images/demos-img/sport.jpg'
    ],
    [
        'id' => 'extreme',
        'title' => 'Extreme Sports',
        'icon' => 'icon-code',
        'description' => 'Gear for adventure and extreme sports',
        'products' => '250+',
        'rating' => '4.8',
        'link' => 'index-24.php',
        'image' => 'assets/images/demos-img/extreme.jpg'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EZbuy - AI-Powered Shopping Experience</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.min.css">
    
    <style>
        /* Keep existing styles unchanged */
        :root {
            --primary-color: #4A90E2;
            --secondary-color: #2C3E50;
            --accent-color: #E74C3C;
            --background-light: #F8F9FA;
            --text-dark: #2C3E50;
            --text-light: #95A5A6;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-light);
        }

        .hero-section {
            position: relative;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            overflow: hidden;
            padding: 100px 0;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            color: white;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 3rem;
            opacity: 0.9;
        }

        .category-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: var(--bg-image);
            background-size: cover;
            background-position: center;
            opacity: 0.1;
            transition: opacity 0.3s ease;
        }

        .category-card:hover::before {
            opacity: 0.2;
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .category-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
            position: relative;
        }

        .category-icon i {
            font-size: 2.5rem;
        }

        .category-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--text-dark);
            position: relative;
        }

        .category-description {
            color: var(--text-light);
            margin-bottom: 1rem;
            position: relative;
            min-height: 48px;
        }

        .category-stats {
            display: flex;
            justify-content: space-between;
            padding-top: 1rem;
            border-top: 1px solid rgba(0,0,0,0.1);
            color: var(--text-light);
            font-size: 0.9rem;
            position: relative;
        }

        .ai-features {
            padding: 5rem 0;
            background: linear-gradient(45deg, #2C3E50, #3498DB);
            color: white;
        }

        .feature-card {
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 2rem;
            backdrop-filter: blur(10px);
            margin-bottom: 2rem;
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .feature-icon i {
            font-size: 2.5rem;
        }

        .btn-custom {
            background: var(--accent-color);
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
            color: white;
        }

        .navbar {
            transition: background-color 0.3s ease;
            padding: 1rem 0;
        }

        .navbar-brand img {
            height: 30px;
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover img {
            transform: scale(1.1);
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        .floating-image {
            animation: float 6s ease-in-out infinite;
            max-width: 80%;
            margin: 0 auto;
            display: block;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background: rgba(0,0,0,0.1); backdrop-filter: blur(10px);">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="assets/images/demos/demo-20/EZbuy.png" alt="EZbuy Logo" height="30">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#categories">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <?php if($username == 'Guest'): ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-custom ml-2" href="users_area/user_login.php">Login</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="users_area/dashboard.php"><?php echo $username; ?></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center hero-content">
                <div class="col-lg-6">
                    <h1 class="hero-title">Welcome to the Future of Shopping</h1>
                    <p class="hero-subtitle">Experience AI-powered personalized shopping across multiple niches</p>
                    <a href="#categories" class="btn btn-custom btn-lg">Explore Stores</a>
                </div>
                <div class="col-lg-6">
                    <img src="assets/images/demos-img/header_splash.jpg" alt="AI Shopping" class="img-fluid floating-image">
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section id="categories" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Specialized Stores</h2>
            <div class="row">
                <?php foreach($categories as $index => $category): ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="category-card" 
                             onclick="window.location.href='<?php echo $category['link']; ?>'"
                             style="--bg-image: url('<?php echo $category['image']; ?>')">
                            <div class="category-icon">
                                <i class="<?php echo $category['icon']; ?>"></i>
                            </div>
                            <h3 class="category-title"><?php echo $category['title']; ?></h3>
                            <p class="category-description"><?php echo $category['description']; ?></p>
                            <div class="category-stats">
                                <span><?php echo $category['products']; ?> Products</span>
                                <span>⭐ <?php echo $category['rating']; ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- AI Features Section -->
    <section id="features" class="ai-features">
        <div class="container">
            <h2 class="text-center mb-5">AI-Powered Shopping Experience</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="icon-cogs"></i>
                        </div>
                        <h3>Smart Recommendations</h3>
                        <p>AI-driven product suggestions based on your preferences and browsing history</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="icon-search"></i>
                        </div>
                        <h3>Visual Search</h3>
                        <p>Find products by uploading images or using our visual search technology</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="icon-envelope-open-text"></i>
                        </div>
                        <h3>AI Assistant</h3>
                        <p>24/7 intelligent chatbot support for all your shopping needs</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include("./includes/footer.php"); ?>

    <!-- Scripts -->
    <script src="lib/jquery/jquery.min.js"></script>
    <script src="lib/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="lib/jquery.appear/jquery.appear.min.js"></script>
    <script src="lib/jquery.lazyload/jquery.lazyload.min.js"></script>
    <script src="assets/main.js"></script>
    
    <script>
        // Keep the JavaScript unchanged
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                document.querySelector('.navbar').style.background = 'rgba(0,0,0,0.8)';
            } else {
                document.querySelector('.navbar').style.background = 'rgba(0,0,0,0.1)';
            }
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.category-card').forEach(card => {
            observer.observe(card);
        });
    </script>
</body>
</html>