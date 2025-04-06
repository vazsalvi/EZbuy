<?php
// Get cart count
$cart_count = 0;
if (isset($_SESSION['user_id'])) {
    $cart_count = getCartCount($con, $_SESSION['user_id']);
}
?>
<header class="header">
    <div class="header-top">
        <div class="container">
            <div class="header-left">
                <div class="header-dropdown">
                    <a href="#">INR</a>
                    <div class="header-menu">
                        <ul>
                            <li><a href="#">Eur</a></li>
                            <li><a href="#">Usd</a></li>
                        </ul>
                    </div>
                </div>

                <div class="header-dropdown">
                    <a href="#">Eng</a>
                    <div class="header-menu">
                        <ul>
                            <li><a href="#">English</a></li>
                            <li><a href="#">Hindi</a></li>
                            <li><a href="#">Marathi</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="header-right">
                <ul class="top-menu">
                    <li>
                        <a href="#">Links</a>
                        <ul>
                            <li><a href="tel:#"><i class="icon-phone"></i>Call: 09833308442</a></li>
                            <li><a href="/Ai_driven_ecommerce/users_area/wishlist.php"><i class="icon-heart-o"></i>Wishlist </a></li>
                            <li><a href="/Ai_driven_ecommerce/about.php">About Us</a></li>
                            <li><a href="/Ai_driven_ecommerce/contact.php">Contact Us</a></li>
                            <?php if (!isset($_SESSION['user_id'])): ?>
                                <li><a href="/Ai_driven_ecommerce/users_area/user_login.php">Login</a></li>
                            <?php else: ?>
                                <li><a href="/Ai_driven_ecommerce/users_area/dashboard.php"><?php echo $_SESSION['username']; ?></a></li>
                                <li><a href="/Ai_driven_ecommerce/users_area/logout.php">Logout</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="header-middle sticky-header">
        <div class="container">
            <div class="header-left">
                <button class="mobile-menu-toggler">
                    <span class="sr-only">Toggle mobile menu</span>
                    <i class="icon-bars"></i>
                </button>

                <a href="/Ai_driven_ecommerce/index.php" class="logo">
                    <img src="/Ai_driven_ecommerce/assets/images/demos/demo-20/EZbuy.png" alt="EZbuy Logo" width="105" height="25">
                </a>

                <nav class="main-nav">
                    <ul class="menu sf-arrows">
                        <li class="megamenu-container active">
                            <a href="/Ai_driven_ecommerce/index.php">Home</a>
                        </li>
                        <li>
                            <a href="/Ai_driven_ecommerce/users_area/category.php">Shop</a>
                        </li>
                        <li>
                            <a href="/Ai_driven_ecommerce/blog.php">Blog</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="header-right">
                <div class="header-icons-wrapper">
                    <div class="icon-box">
                        <a href="#" class="icon-link" role="button" title="Search">
                            <i class="icon-search"></i>
                        </a>
                    </div>

                    <div class="icon-box">
                        <a href="/Ai_driven_ecommerce/file.php" class="icon-link" role="button" title="Visual Search">
                            <i class="icon-eye"></i>
                        </a>
                    </div>

                    <div class="icon-box">
                        <a href="/Ai_driven_ecommerce/users_area/cart.php" class="icon-link" role="button">
                            <i class="icon-shopping-cart"></i>
                        </a>
                    </div>

                    <div class="icon-box">
                        <a href="/Ai_driven_ecommerce/users_area/dashboard.php" class="icon-link" title="My account">
                            <i class="icon-user"></i>
                        </a>
                    </div>

                    <form action="/Ai_driven_ecommerce/users_area/category.php" method="get" class="search-form">
                        <div class="header-search-wrapper">
                            <label for="q" class="sr-only">Search</label>
                            <input type="search" class="form-control" name="q" id="q" placeholder="Search in..." required>
                            <button class="btn" type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>

                <style>
                    .header-icons-wrapper {
                        display: flex;
                        align-items: center;
                        gap: 3rem;
                        margin-left: 15%;
                    }
                    .icon-box {
                        display: flex;
                        align-items: center;
                        padding: 0.5rem;
                    }
                    .icon-link {
                        font-size: 2.4rem;
                        color: #333;
                        transition: color 0.3s;
                        display: flex;
                        align-items: center;
                    }
                    .icon-link:hover {
                        color: #fcb941;
                    }
                    .cart-count {
                        position: absolute;
                        top: -0.5rem;
                        right: -0.5rem;
                        font-size: 1rem;
                        background: #fcb941;
                        color: #fff;
                        border-radius: 50%;
                        width: 1.8rem;
                        height: 1.8rem;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }
                    .search-form {
                        display: none;
                    }
                    .header-search-wrapper.show {
                        display: block;
                    }
                </style>
            </div>
        </div>
    </div>
</header>