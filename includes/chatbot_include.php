<?php
// Get the current page name
$current_page = basename($_SERVER['PHP_SELF']);

// Only include chatbot if not on index.php
if ($current_page !== 'index.php') {
    include __DIR__ . '/chatbot.html';
    ?>
    <script src="/Ai_driven_ecommerce/lib/jquery/jquery.min.js"></script>
    <script src="/Ai_driven_ecommerce/js/chatbot.js"></script>

    <!-- Load Chatbot Script -->
    <script src="/Ai_driven_ecommerce/js/chatbot.js"></script>
    <style>
        .chat-toggle {
            position: fixed !important;
            bottom: 20px !important;
            right: 20px !important;
            z-index: 99999 !important;
            cursor: pointer !important;
        }
        .chat-container {
            position: fixed !important;
            bottom: 100px !important;
            right: 20px !important;
            width: 350px !important;
            height: 500px !important;
            background: white !important;
            border-radius: 10px !important;
            box-shadow: 0 5px 25px rgba(0,0,0,0.2) !important;
            display: none;
            flex-direction: column !important;
            z-index: 99999 !important;
            overflow: hidden !important;
        }
        .chat-header {
            padding: 15px !important;
            background: #4A90E2 !important;
            color: white !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
        }
        .chat-messages {
            flex: 1 !important;
            overflow-y: auto !important;
            padding: 15px !important;
        }
        .chat-input {
            padding: 15px !important;
            border-top: 1px solid #eee !important;
            display: flex !important;
            gap: 10px !important;
        }
        .chat-input input {
            flex: 1 !important;
            padding: 8px !important;
            border: 1px solid #ddd !important;
            border-radius: 20px !important;
            outline: none !important;
        }
        .send-button {
            background: #4A90E2 !important;
            color: white !important;
            border: none !important;
            border-radius: 50% !important;
            width: 35px !important;
            height: 35px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
        }
        .bot-message, .user-message {
            margin-bottom: 15px !important;
            display: flex !important;
            align-items: flex-start !important;
        }
        .message-content {
            padding: 10px 15px !important;
            border-radius: 15px !important;
            max-width: 80% !important;
            word-wrap: break-word !important;
        }
        .bot-message .message-content {
            background: #f0f0f0 !important;
            margin-left: 10px !important;
        }
        .user-message {
            justify-content: flex-end !important;
        }
        .user-message .message-content {
            background: #4A90E2 !important;
            color: white !important;
        }
        .suggestion-buttons {
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 5px !important;
            margin-top: 10px !important;
        }
        .suggestion-btn {
            background: #fff !important;
            border: 1px solid #4A90E2 !important;
            color: #4A90E2 !important;
            padding: 5px 10px !important;
            border-radius: 15px !important;
            cursor: pointer !important;
            font-size: 12px !important;
        }
        .suggestion-btn:hover {
            background: #4A90E2 !important;
            color: #fff !important;
        }
    </style>
    <?php
}
?>