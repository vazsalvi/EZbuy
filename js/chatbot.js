// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', () => {
    // Wait a short moment to ensure all elements are rendered
    setTimeout(() => {
        initChatbot();
    }, 500);
});

function initChatbot() {
    // Get DOM elements
    const chatContainer = document.querySelector('.chat-container');
    const chatMessages = document.querySelector('.chat-messages');
    const chatInput = document.querySelector('.chat-input input');
    const sendButton = document.querySelector('.send-button');
    const closeButton = document.querySelector('.close-chat');
    const chatToggle = document.querySelector('.chat-toggle');

    // Check if all required elements exist
    if (!chatContainer || !chatMessages || !chatInput || !sendButton || !closeButton || !chatToggle) {
        console.error('Some chatbot elements are missing:', {
            chatContainer: !!chatContainer,
            chatMessages: !!chatMessages,
            chatInput: !!chatInput,
            sendButton: !!sendButton,
            closeButton: !!closeButton,
            chatToggle: !!chatToggle
        });
        return;
    }

    // Initialize chatbot state
    let isChatVisible = false;

    // Prevent background scroll when mouse is over chatbot
    chatContainer.addEventListener('mouseenter', () => {
        document.body.style.overflow = 'hidden';
    });

    chatContainer.addEventListener('mouseleave', () => {
        document.body.style.overflow = 'auto';
    });

    // Prevent background scroll on mobile touch
    chatContainer.addEventListener('touchstart', (e) => {
        if (e.target.closest('.chat-messages')) {
            e.stopPropagation();
        }
    }, { passive: true });

    // Handle chat messages scroll
    chatMessages.addEventListener('wheel', (e) => {
        e.stopPropagation();
    });

    // Predefined queries for quick access
    const suggestedQueries = [
        {
            text: "Find Products",
            query: "Can you help me find products to buy?"
        },
        {
            text: "Track Order",
            query: "How can I track my order?"
        },
        {
            text: "Shipping Info",
            query: "Tell me about your shipping options"
        },
        {
            text: "Return Policy",
            query: "What is your return policy?"
        }
    ];

    // Add welcome message with buttons
    const welcomeMessage = `Hi! I'm Pearl, your shopping assistant. How can I help you today?`;
    const buttonsHtml = suggestedQueries.map(query => `
        <button class="suggestion-btn" data-query="${query.query}">
            ${query.text}
        </button>
    `).join('');

    chatMessages.innerHTML = `
        <div class="bot-message">
            <div class="bot-avatar">🛍️</div>
            <div class="message-content">
                ${welcomeMessage}
                <div class="suggestion-buttons">
                    ${buttonsHtml}
                </div>
            </div>
        </div>
    `;

    // Handle suggestion button clicks
    function attachSuggestionButtonHandlers() {
        document.querySelectorAll('.suggestion-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                e.stopPropagation();
                const query = button.getAttribute('data-query');
                chatInput.value = query;
                handleUserInput();
            });
        });
    }

    attachSuggestionButtonHandlers();

    // Toggle chat visibility
    function toggleChat() {
        isChatVisible = !isChatVisible;
        chatContainer.style.display = isChatVisible ? 'flex' : 'none';
        
        if (isChatVisible) {
            chatInput.focus();
            // Close newsletter popup if it exists
            if (window.$.magnificPopup && window.$.magnificPopup.instance.isOpen) {
                window.$.magnificPopup.instance.close();
            }
        }
    }

    // Ensure event listeners are properly attached
    chatToggle.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        toggleChat();
    });

    closeButton.addEventListener('click', () => {
        toggleChat();
        document.body.style.overflow = 'auto';
    });

    // Show typing indicator
    function showTypingIndicator() {
        chatMessages.innerHTML += `
            <div class="bot-message typing-indicator">
                <div class="bot-avatar">🛍️</div>
                <div class="message-content">
                    <div class="typing-dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        `;
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Remove typing indicator
    function removeTypingIndicator() {
        const typingIndicator = chatMessages.querySelector('.typing-indicator');
        if (typingIndicator) {
            typingIndicator.remove();
        }
    }

    // Add suggestion buttons after bot response
    function addSuggestionButtons(messageElement) {
        // Only add suggestion buttons if this is the first message
        if (chatMessages.querySelectorAll('.user-message').length === 0) {
            const buttonsContainer = document.createElement('div');
            buttonsContainer.className = 'suggestion-buttons';
            buttonsContainer.innerHTML = suggestedQueries.map(query => `
                <button class="suggestion-btn" data-query="${query.query}">
                    ${query.text}
                </button>
            `).join('');

            messageElement.querySelector('.message-content').appendChild(buttonsContainer);
            attachSuggestionButtonHandlers();
        }
    }

    async function handleUserInput() {
        const message = chatInput.value.trim();
        if (!message) return;

        // Add user message
        chatMessages.innerHTML += `
            <div class="user-message">
                <div class="message-content">${message}</div>
            </div>
        `;
        chatInput.value = '';
        chatMessages.scrollTop = chatMessages.scrollHeight;

        // Show typing indicator
        showTypingIndicator();

        try {
            console.log('Sending message to chatbot:', message);

            const response = await fetch('chatbot.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ message })
            });

            console.log('Response status:', response.status);

            if (!response.ok) {
                const errorText = await response.text();
                console.error('Error response text:', errorText);
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const responseText = await response.text();
            console.log('Raw response text:', responseText);

            let data;
            try {
                data = JSON.parse(responseText);
                console.log('Parsed response data:', data);
            } catch (e) {
                console.error('JSON parse error:', e);
                throw new Error('Failed to parse response as JSON');
            }
            
            // Remove typing indicator
            removeTypingIndicator();
            
            if (data.error) {
                console.error('API error:', data.error);
                throw new Error(data.error);
            }

            if (!data.response) {
                console.error('Invalid response format:', data);
                throw new Error('Invalid response format from server');
            }
            
            // Add bot response with animation
            const botMessageDiv = document.createElement('div');
            botMessageDiv.className = 'bot-message fade-in';
            botMessageDiv.innerHTML = `
                <div class="bot-avatar">🛍️</div>
                <div class="message-content">${data.response.replace(/\n/g, '<br>')}</div>
            `;
            
            chatMessages.appendChild(botMessageDiv);
            
            // Add suggestion buttons after response
            addSuggestionButtons(botMessageDiv);
            
            // Smooth scroll to bottom
            chatMessages.scrollTo({
                top: chatMessages.scrollHeight,
                behavior: 'smooth'
            });

        } catch (error) {
            console.error('Chat Error:', error);
            removeTypingIndicator();
            chatMessages.innerHTML += `
                <div class="error-message fade-in">
                    ⚠️ Error: ${error.message}
                </div>
            `;
        }
    }

    sendButton.addEventListener('click', handleUserInput);

    chatInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') handleUserInput();
    });

    // Prevent background scroll when scrolling chat messages on mobile
    chatMessages.addEventListener('touchmove', (e) => {
        e.stopPropagation();
    }, { passive: true });

    // Close chat when clicking outside
    document.addEventListener('click', (e) => {
        if (isChatVisible && !chatContainer.contains(e.target) && !chatToggle.contains(e.target)) {
            toggleChat();
        }
    });

    // Log initialization success
    console.log('Chatbot initialized successfully');
}
