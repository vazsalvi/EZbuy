<?php
require_once __DIR__ . '/includes/connect.php';

try {
    $sql = "CREATE TABLE IF NOT EXISTS chat_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_message TEXT NOT NULL,
        bot_response TEXT NOT NULL,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if (mysqli_query($con, $sql)) {
        echo "Chat logs table created successfully";
    } else {
        throw new Exception("Error creating table: " . mysqli_error($con));
    }
} catch(Exception $e) {
    echo "Error creating table: " . $e->getMessage();
}
?>