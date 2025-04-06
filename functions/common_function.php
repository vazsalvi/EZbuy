<?php
// Get all categories
function getCategories($con) {
    return $con->query('categories');
}

// Get featured categories
function getFeaturedCategories($con, $limit = 4) {
    $all = $con->query('categories', ['featured' => true]);
    return array_slice($all, 0, $limit);
}

// Get products by category
function getProductsByCategory($con, $category_id, $limit = 12) {
    $all = $con->query('products', ['category_id' => $category_id]);
    usort($all, function($a, $b) {
        return $b['id'] - $a['id']; // Sort by ID descending
    });
    return array_slice($all, 0, $limit);
}

// Get featured products (shows recent products)
function getFeaturedProducts($con, $limit = 8) {
    $all = $con->query('products');
    usort($all, function($a, $b) {
        return $b['id'] - $a['id']; // Sort by ID descending
    });
    return array_slice($all, 0, $limit);
}

// Get hot deals (products with biggest price difference)
function getHotDeals($con, $limit = 4) {
    $all = $con->query('products');
    shuffle($all); // Random selection
    return array_slice($all, 0, $limit);
}

// Get new arrivals (most recent products)
function getNewArrivals($con, $limit = 8) {
    $all = $con->query('products');
    usort($all, function($a, $b) {
        return strtotime($b['created_at']) - strtotime($a['created_at']);
    });
    return array_slice($all, 0, $limit);
}

// Get top rated products
function getTopRatedProducts($con, $limit = 4) {
    $all = $con->query('products');
    usort($all, function($a, $b) {
        $a_rating = isset($a['rating']) ? $a['rating'] : 0;
        $b_rating = isset($b['rating']) ? $b['rating'] : 0;
        $a_review_count = isset($a['review_count']) ? $a['review_count'] : 0;
        $b_review_count = isset($b['review_count']) ? $b['review_count'] : 0;
        
        if ($a_rating != $b_rating) {
            return $b_rating - $a_rating;
        }
        return $b_review_count - $a_review_count;
    });
    return array_slice($all, 0, $limit);
}

// Get brands by category
function getBrandsByCategory($con, $category_id) {
    return $con->query('brands', ['category_id' => $category_id]);
}

// Search products
function searchProducts($con, $search_term) {
    $all = $con->query('products');
    $search_term = strtolower($search_term);
    
    return array_filter($all, function($product) use ($search_term) {
        return strpos(strtolower($product['title']), $search_term) !== false ||
               strpos(strtolower($product['description']), $search_term) !== false ||
               strpos(strtolower($product['keywords']), $search_term) !== false;
    });
}

// Get product details
function getProductDetails($con, $product_id) {
    $products = $con->query('products', ['id' => $product_id]);
    return !empty($products) ? $products[0] : null;
}

// Get related products
function getRelatedProducts($con, $product_id, $category_id, $limit = 4) {
    $all = $con->query('products', ['category_id' => $category_id]);
    $filtered = array_filter($all, function($product) use ($product_id) {
        return $product['id'] != $product_id;
    });
    shuffle($filtered);
    return array_slice($filtered, 0, $limit);
}

// Get product reviews
function getProductReviews($con, $product_id) {
    return $con->query('reviews', ['product_id' => $product_id]);
}

// Add to cart
function addToCart($con, $user_id, $product_id, $quantity = 1) {
    $existing = $con->query('cart', [
        'user_id' => $user_id,
        'product_id' => $product_id
    ]);

    if (!empty($existing)) {
        $item = $existing[0];
        return $con->update('cart', $item['id'], [
            'quantity' => $item['quantity'] + $quantity
        ]);
    } else {
        return $con->insert('cart', [
            'user_id' => $user_id,
            'product_id' => $product_id,
            'quantity' => $quantity
        ]);
    }
}

// Add to wishlist
function addToWishlist($con, $user_id, $product_id) {
    $existing = $con->query('wishlist', [
        'user_id' => $user_id,
        'product_id' => $product_id
    ]);

    if (empty($existing)) {
        return $con->insert('wishlist', [
            'user_id' => $user_id,
            'product_id' => $product_id
        ]);
    }
    return true;
}

// Format price
function formatPrice($price) {
    return '₹' . number_format($price, 2);
}

// Calculate discount percentage
function calculateDiscount($original_price, $sale_price) {
    if ($sale_price && $original_price > $sale_price) {
        return round(($original_price - $sale_price) / $original_price * 100);
    }
    return 0;
}

// Display star rating
function displayRating($rating) {
    $output = '';
    $full_stars = floor($rating);
    $half_star = $rating - $full_stars >= 0.5;
    $empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);
    
    for ($i = 0; $i < $full_stars; $i++) {
        $output .= '<i class="icon-star"></i>';
    }
    if ($half_star) {
        $output .= '<i class="icon-star-half"></i>';
    }
    for ($i = 0; $i < $empty_stars; $i++) {
        $output .= '<i class="icon-star-o"></i>';
    }
    
    return $output;
}

// Get cart count
function getCartCount($con, $user_id) {
    return $con->count('cart', ['user_id' => $user_id]);
}

// Get wishlist count
function getWishlistCount($con, $user_id) {
    return $con->count('wishlist', ['user_id' => $user_id]);
}

// Sanitize input
function sanitizeInput($con, $input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}