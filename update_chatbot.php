<?php
// Get all PHP files in the current directory and subdirectories
function getAllPhpFiles($dir) {
    $files = array();
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $files[] = $file->getPathname();
        }
    }
    return $files;
}

// Function to update file content
function updateFile($filePath) {
    $content = file_get_contents($filePath);
    
    // Remove any existing chatbot include
    $content = preg_replace('/\<\?php include\(\'\.\/includes\/chatbot\.html\'\); \?\>/', '', $content);
    
    // Add chatbot include before </body> tag
    $content = str_replace('</body>', "    <!-- Include Chatbot -->\n    <?php include './includes/chatbot.html'; ?>\n</body>", $content);
    
    file_put_contents($filePath, $content);
    echo "Updated: " . basename($filePath) . "\n";
}

// Get all PHP files
$files = getAllPhpFiles('.');

// Update each file
foreach ($files as $file) {
    // Skip certain files
    if (basename($file) === 'update_chatbot.php' || 
        basename($file) === 'connect.php' || 
        basename($file) === 'common_function.php' ||
        basename($file) === '10_function.php' ||
        strpos($file, 'admin_area') !== false) {
        continue;
    }
    updateFile($file);
}

echo "Update complete!\n";
?>