<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>atPay Chat Support</title>
           <link rel="icon" type="image/png" href="../../images/logo.png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="chat-container">
       <div class="chat-header">
    <button class="back-btn" onclick="history.back()" aria-label="Go back">
        <i class="fas fa-arrow-left"></i>
    </button>
    <h1 class="header-title">atPay Chat Support</h1>
</div>

        
        <div class="chat-messages" id="chat-messages">
            <!-- Messages will be dynamically added here -->
        </div>
        
        <div class="typing-indicator" id="typing-indicator">
            <div class="typing-dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <span>Admin is typing</span>
        </div>
        
        <div class="chat-input-container">
            <input type="text" class="chat-input" id="chat-input" placeholder="Type a message..." aria-label="Type your message">
            <button class="send-btn" id="send-btn" aria-label="Send message">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>

    <script>
        const chatMessages = document.getElementById('chat-messages');
        const chatInput = document.getElementById('chat-input');
        const sendBtn = document.getElementById('send-btn');
        const typingIndicator = document.getElementById('typing-indicator');

        // Sample conversation data matching the image
        const initialMessages = [
            { text: "askis", sender: "user", timestamp: "Jun 17, 2025" },
            { text: "askis", sender: "user", timestamp: "Jun 17, 2025" },
            { text: "askis", sender: "user", timestamp: "Jun 17, 2025" },
            { text: "Hello, how can I help?", sender: "admin", timestamp: "Jun 18, 2025" },
            { text: "hello", sender: "user", timestamp: "Jun 25, 2025" },
            { text: "Have a great day!", sender: "admin", timestamp: "Jun 25, 2025" },
            { text: "WEB", sender: "admin", timestamp: "Jun 25, 2025" }
        ];

        // Admin response templates
        const adminResponses = [
            "Hello! How can I assist you today?",
            "Thank you for reaching out! What's your question?",
            "I'm here to help. Please describe your issue.",
            "Can you provide more details about that?",
            "Let me check on that for you!",
            "Is there anything else I can help you with?",
            "Have a great day!",
            "Thank you for contacting atPay support!"
        ];

        // Add message to chat
        function addMessage(text, sender, timestamp = null) {
            const messageDiv = document.createElement('div');
            messageDiv.classList.add('message', sender);
            
            const timeStr = timestamp || new Date().toLocaleDateString('en-US', { 
                month: 'short', 
                day: 'numeric', 
                year: 'numeric' 
            });
            
            const readIndicator = sender === 'user' ? '<i class="fas fa-check-double read-indicator"></i>' : '';
            
            messageDiv.innerHTML = `
                <div class="message-bubble">${text}</div>
                <div class="message-timestamp">${timeStr} ${readIndicator}</div>
            `;
            
            chatMessages.appendChild(messageDiv);
            scrollToBottom();
        }

        // Scroll to bottom of chat
        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Show typing indicator
        function showTypingIndicator() {
            typingIndicator.classList.add('active');
            scrollToBottom();
            
            setTimeout(() => {
                typingIndicator.classList.remove('active');
            }, 1500);
        }

        // Simulate admin response
        function sendAdminResponse() {
            showTypingIndicator();
            
            setTimeout(() => {
                const randomResponse = adminResponses[Math.floor(Math.random() * adminResponses.length)];
                addMessage(randomResponse, 'admin');
            }, 2000);
        }

        // Handle send message
        function sendMessage() {
            const message = chatInput.value.trim();
            if (message) {
                addMessage(message, 'user');
                chatInput.value = '';
                
                // Send admin response after user message
                setTimeout(() => {
                    sendAdminResponse();
                }, 500);
            }
        }

        // Event listeners
        sendBtn.addEventListener('click', sendMessage);
        
        chatInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                sendMessage();
            }
        });

        // Back button functionality
        document.querySelector('.back-btn').addEventListener('click', () => {
            // You can implement navigation logic here
            console.log('Back button clicked');
        });

        // Initialize chat with sample messages
        function initializeChat() {
            initialMessages.forEach((msg, index) => {
                setTimeout(() => {
                    addMessage(msg.text, msg.sender, msg.timestamp);
                }, index * 200);
            });
        }

        // Start the chat
        initializeChat();
        
        // Focus input after initialization
        setTimeout(() => {
            chatInput.focus();
        }, initialMessages.length * 200 + 500);
    </script>
</body>
</html>