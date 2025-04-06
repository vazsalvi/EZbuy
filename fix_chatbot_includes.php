<?php
// List of files to check
$files = [
    'index-10.php', 'index-11.php', 'index-12.php', 'index-19.php', 
    'index-20.php', 'index-21.php', 'index-24.php',
    'users_area/category.php', 'users_area/product.php', 
    'users_area/dashboard.php', 'users_area/wishlist.php',
    'about.php', 'blog.php', 'faq.php', 'file.php',
    'payment_page.php', 'test.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        // Remove direct chatbot inclusions
        $content = preg_replace('/\s*<!-- Include Chatbot -->\s*/', '', $content);
        $content = preg_replace('/\s*<\?php include \'\.\/includes\/chatbot\.html\'; \?>\s*/', '', $content);
        $content = preg_replace('/\s*<script src="js\/chatbot\.js"><\/script>\s*/', '', $content);
        
        file_put_contents($file, $content);
        echo "Processed $file\n";
    }
}

echo "Completed removing duplicate chatbot inclusions.\n";
?>