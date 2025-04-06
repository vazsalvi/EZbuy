<?php
require_once('includes/connect.php');

// Sample product data
$products = [
    [
        'product_title' => 'iPhone 13 Pro',
        'product_description' => 'Latest iPhone with A15 Bionic chip, Pro camera system, and Super Retina XDR display with ProMotion',
        'product_price' => 99999,
        'category' => 'electronics',
        'subcategory' => 'smartphones'
    ],
    [
        'product_title' => 'Samsung Galaxy S21',
        'product_description' => 'Flagship Android smartphone with 5G, Dynamic AMOLED display, and professional-grade camera system',
        'product_price' => 79999,
        'category' => 'electronics',
        'subcategory' => 'smartphones'
    ],
    [
        'product_title' => 'MacBook Pro 14"',
        'product_description' => 'Powerful laptop with M1 Pro chip, Liquid Retina XDR display, and up to 17 hours of battery life',
        'product_price' => 149999,
        'category' => 'electronics',
        'subcategory' => 'laptops'
    ],
    [
        'product_title' => 'Dell XPS 13',
        'product_description' => 'Premium ultrabook with InfinityEdge display, Intel Core i7, and long battery life',
        'product_price' => 129999,
        'category' => 'electronics',
        'subcategory' => 'laptops'
    ],
    [
        'product_title' => 'iPad Air',
        'product_description' => 'Versatile tablet with M1 chip, 10.9-inch Liquid Retina display, and Apple Pencil support',
        'product_price' => 54999,
        'category' => 'electronics',
        'subcategory' => 'tablets'
    ],
    [
        'product_title' => 'Sony WH-1000XM4',
        'product_description' => 'Premium wireless noise-cancelling headphones with exceptional sound quality',
        'product_price' => 29999,
        'category' => 'electronics',
        'subcategory' => 'accessories'
    ],
    [
        'product_title' => 'Apple Watch Series 7',
        'product_description' => 'Advanced smartwatch with larger display, faster charging, and comprehensive health features',
        'product_price' => 41999,
        'category' => 'electronics',
        'subcategory' => 'wearables'
    ],
    [
        'product_title' => 'PlayStation 5',
        'product_description' => 'Next-gen gaming console with 4K graphics, ray tracing, and ultra-high speed SSD',
        'product_price' => 49999,
        'category' => 'electronics',
        'subcategory' => 'gaming'
    ]
];

try {
    // Clear existing products
    $con->resetCollection('products');
    
    // Add new products
    foreach ($products as $product) {
        $con->insert('products', $product);
    }
    
    echo "Sample products added successfully!\n";
    echo "Total products added: " . count($products) . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}