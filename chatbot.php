<?php
// Enable error reporting for development
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Start session and set headers
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Include database connection
require_once('includes/connect.php');

// Google API Configuration
$GOOGLE_API_KEY = 'AIzaSyDPV8Y1PIXOmYfzu38u1fyyWE3UPBETf8U';

// Function to search products using JsonDB
function searchProducts($query, $db) {
    $allProducts = $db->query('products');
    $matchingProducts = [];
    
    // Extract meaningful keywords from query
    $keywords = explode(' ', strtolower($query));
    $keywords = array_filter($keywords, function($word) {
        // Filter out common words
        $commonWords = ['show', 'me', 'find', 'search', 'looking', 'for', 'want', 'to', 'buy', 'available'];
        return !in_array($word, $commonWords);
    });
    
    foreach ($allProducts as $product) {
        foreach ($keywords as $keyword) {
            if (stripos($product['product_title'], $keyword) !== false || 
                stripos($product['product_description'], $keyword) !== false ||
                stripos($product['category'], $keyword) !== false ||
                stripos($product['subcategory'], $keyword) !== false) {
                $matchingProducts[] = [
                    'title' => $product['product_title'],
                    'price' => $product['product_price'],
                    'description' => substr($product['product_description'], 0, 100) . '...',
                    'url' => "product.php?product_id=" . $product['id']
                ];
                break; // Break once we've matched this product
            }
        }
        
        if (count($matchingProducts) >= 5) break; // Limit to 5 results
    }
    return $matchingProducts;
}

try {
    // Log the raw input for debugging
    error_log("Received input: " . file_get_contents('php://input'));

    // Get user message
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    $userMessage = $data['message'] ?? '';

    if (empty($userMessage)) {
        throw new Exception('No message received');
    }

    // Log the processed message
    error_log("Processing message: " . $userMessage);

    // Process the message and get appropriate response
    $lowercaseMessage = strtolower($userMessage);
    $botResponse = '';

    // Define detailed responses for different categories
    $responses = [
        // Basic queries
        'hello' => "Hi! How can I help you with your shopping today?",
        'hi' => "Hello! Looking for something specific? I can help you find it!",
        'help' => "I can help you:\n- Find products by category\n- Search specific items\n- Check prices\n- Get product information\n- Track orders\n- Learn about shipping\nWhat would you like to know?",
        
        // Shipping related
        'shipping' => "We offer several shipping options:\n- Free shipping on orders over Rs 500\n- Standard delivery (3-5 days)\n- Express delivery (1-2 days)\n- International shipping\n\nWould you like more details about any of these options?",
        'delivery' => "Our delivery options include:\n- Standard delivery (3-5 days)\n- Express delivery (1-2 days)\n- International shipping\n\nTracking information is provided for all orders.",
        
        // Returns and policies
        'return' => "Our return policy includes:\n- 30-day return window\n- Free returns\n- Original condition required\n- Full refund or store credit\n\nNeed help with a return?",
        'refund' => "Our refund policy:\n- Full refunds processed within 5-7 business days\n- Store credit available instantly\n- Original payment method refund\n\nNeed help with a refund?",
        
        // Product categories
        'electronics' => "Our electronics section includes:\n- Smartphones\n- Laptops\n- Tablets\n- Accessories\n- Gaming devices\n\nWhat type of electronics are you interested in?",
        'fashion' => "Our fashion collection includes:\n- Men's Wear\n- Women's Wear\n- Kids' Fashion\n- Sports Wear\n- Accessories\n\nWhat type of clothing are you looking for?",
        'books' => "Our book collection includes:\n- Fiction\n- Non-Fiction\n- Academic\n- Children's Books\n- E-books\n\nWhat genre interests you?",
        
        // Order related
        'track' => "To track your order, please provide your order number and I'll help you check its status. You can find your order number in your confirmation email.",
        'order status' => "I can help you check your order status. Please provide your order number from your confirmation email.",
        'cancel order' => "Need to cancel an order? I can help with that. Please provide your order number and I'll check if it's eligible for cancellation.",
        
        // Price related
        'price' => "I can help you find products in your budget. Could you specify:\n1. What type of product you're looking for?\n2. Your preferred price range?",
        'discount' => "I can help you find the best deals! We have:\n- Daily deals\n- Seasonal sales\n- Bundle offers\n- Student discounts\n\nWhat type of products are you interested in?",
        
        // Default response
        'default' => "I'm here to help you find the perfect products! You can ask me about:\n- Product recommendations\n- Price information\n- Shipping details\n- Order tracking\n- Returns and refunds\n\nWhat would you like to know?"
    ];

    // First, try to find products
    $products = searchProducts($userMessage, $con);
    
    if (!empty($products)) {
        $botResponse = "I found these products that might interest you:\n\n";
        foreach ($products as $product) {
            $botResponse .= "📦 {$product['title']}\n";
            $botResponse .= "💰 Rs.{$product['price']}\n";
            $botResponse .= "ℹ️ {$product['description']}\n";
            $botResponse .= "🔗 <a href='{$product['url']}'>View Product</a>\n\n";
        }
        $botResponse .= "Would you like more specific details about any of these products?";
    } else {
        // If no products found, check for predefined responses
        $foundResponse = false;
        foreach ($responses as $key => $response) {
            if (strpos($lowercaseMessage, $key) !== false) {
                $botResponse = $response;
                $foundResponse = true;
                break;
            }
        }

        // If no matching response found, use Gemini API
        if (!$foundResponse) {
            try {
                // Prepare the API request
                $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=' . $GOOGLE_API_KEY;
                
                // Enhanced context for the AI
                $systemContext = "You are Pearl, an AI shopping assistant for an e-commerce website. Your role is to:
1. Help customers find products and provide recommendations
2. Answer questions about shipping, returns, and general policies
3. Assist with order tracking and customer service inquiries
4. Provide relevant product category suggestions
5. Help with price comparisons and finding deals

Keep responses:
- Concise and friendly
- Focused on shopping-related queries
- Helpful and solution-oriented
- Professional but conversational

If asked about specific products, recommend relevant categories and features to look for rather than specific items.";
                
                // Combine system context and user message
                $prompt = $systemContext . "\n\nCustomer: " . $userMessage . "\n\nAssistant:";

                // Log the API request
                error_log("Sending request to Google API: " . $url);

                // Prepare the request data
                $postData = [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'topK' => 40,
                        'topP' => 0.95,
                        'maxOutputTokens' => 1024,
                    ],
                    'safetySettings' => [
                        [
                            'category' => 'HARM_CATEGORY_HARASSMENT',
                            'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                        ],
                        [
                            'category' => 'HARM_CATEGORY_HATE_SPEECH',
                            'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                        ],
                        [
                            'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
                            'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                        ],
                        [
                            'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
                            'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                        ]
                    ]
                ];

                // Initialize cURL session
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json'
                ]);

                // Execute the request
                $response = curl_exec($ch);
                
                // Log the raw API response
                error_log("Google API Response: " . $response);

                if (curl_errno($ch)) {
                    throw new Exception('API request failed: ' . curl_error($ch));
                }
                
                curl_close($ch);

                // Parse the response
                $responseData = json_decode($response, true);
                
                if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                    $botResponse = $responseData['candidates'][0]['content']['parts'][0]['text'];
                } else {
                    // Log the error and use default response
                    error_log("Failed to parse API response: " . json_encode($responseData));
                    $botResponse = $responses['default'];
                }
            } catch (Exception $e) {
                error_log("API Error: " . $e->getMessage());
                $botResponse = $responses['default'];
            }
        }
    }

    // Store conversation context in session
    if (!isset($_SESSION['conversation_history'])) {
        $_SESSION['conversation_history'] = [];
    }
    
    $_SESSION['conversation_history'][] = [
        'user' => $userMessage,
        'bot' => $botResponse,
        'timestamp' => time()
    ];

    // Keep only last 5 messages for context
    if (count($_SESSION['conversation_history']) > 5) {
        array_shift($_SESSION['conversation_history']);
    }

    // Log the conversation for analysis
    $logData = [
        'timestamp' => date('Y-m-d H:i:s'),
        'user_message' => $userMessage,
        'bot_response' => $botResponse,
        'products_found' => !empty($products)
    ];
    
    // Add to chat logs collection in JsonDB
    $con->insert('chat_logs', $logData);

    // Send successful response
    echo json_encode([
        'status' => 'success',
        'response' => $botResponse
    ]);

} catch (Exception $e) {
    error_log("Chatbot Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'error' => $e->getMessage()
    ]);
}
