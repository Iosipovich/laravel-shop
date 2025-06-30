<!-- Chat Widget -->
<div id="chatWidget" class="fixed bottom-6 right-6 z-30 flex flex-col items-end">
    <!-- Chat Button -->
    <button id="chatToggle" class="bg-blue-600 hover:bg-blue-500 text-white p-4 rounded-full shadow-lg transition-all duration-300 hover:shadow-blue-500/30 flex items-center justify-center">
        <i id="chatIcon" class="fas fa-comments text-xl"></i>
    </button>
    
    <!-- Chat Window -->
    <div id="chatWindow" class="hidden bg-gray-800 rounded-lg shadow-xl border border-gray-700 w-full max-w-sm md:max-w-md mt-4 transition-all duration-300 transform origin-bottom-right scale-95 opacity-0">
        <!-- Chat Header -->
        <div class="bg-gray-900 rounded-t-lg p-4 border-b border-gray-700 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="flex items-center justify-center bg-blue-600 w-10 h-10 rounded-full">
                    <i class="fas fa-robot text-white"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-white">Tech Shop Assistant</h3>
                    <div class="flex items-center">
                        <span class="inline-block w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                        <span class="text-xs text-gray-300">Online</span>
                    </div>
                </div>
            </div>
            <button id="closeChat" class="text-gray-400 hover:text-white transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <!-- Chat Messages -->
        <div id="chatMessages" class="p-4 h-80 overflow-y-auto space-y-4 bg-gradient-to-b from-gray-850 to-gray-800">
            <!-- Welcome Message -->
            <div class="flex items-start">
                <div class="flex-shrink-0 bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-robot text-white text-sm"></i>
                </div>
                <div class="bg-gray-700 rounded-lg rounded-tl-none p-3 max-w-[80%] shadow-md">
                    <p class="text-white text-sm">Добро пожаловать в Tech Shop! Чем я могу вам помочь?</p>
                    <span class="text-xs text-gray-400 block mt-1">сейчас</span>
                </div>
            </div>
        </div>
        
        <!-- Suggested Questions -->
        <div class="p-3 border-t border-gray-700 bg-gray-850">
            <p class="text-xs text-gray-400 mb-2">Популярные вопросы:</p>
            <div class="flex flex-wrap gap-2">
                <button class="suggested-question bg-gray-700 hover:bg-gray-600 text-sm text-white px-3 py-1 rounded-full transition">Доставка</button>
                <button class="suggested-question bg-gray-700 hover:bg-gray-600 text-sm text-white px-3 py-1 rounded-full transition">Акции</button>
                <button class="suggested-question bg-gray-700 hover:bg-gray-600 text-sm text-white px-3 py-1 rounded-full transition">Возврат</button>
                <button class="suggested-question bg-gray-700 hover:bg-gray-600 text-sm text-white px-3 py-1 rounded-full transition">Гарантия</button>
            </div>
        </div>
        
        <!-- Chat Input -->
        <div class="p-3 border-t border-gray-700 bg-gray-850 rounded-b-lg">
            <form id="chatForm" class="flex items-center space-x-2">
                <input type="text" id="messageInput" placeholder="Введите сообщение..." class="bg-gray-700 text-white border border-gray-600 rounded-lg px-4 py-2 flex-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white p-2 rounded-lg transition shadow-md hover:shadow-blue-500/30">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
            <div class="flex justify-between items-center mt-2">
                <div class="text-xs text-gray-400">
                    <i class="fas fa-shield-alt text-blue-500 mr-1"></i> Безопасный чат
                </div>
                <button id="clearChat" class="text-xs text-gray-400 hover:text-gray-300 transition flex items-center">
                    <i class="fas fa-trash-alt mr-1"></i> Очистить чат
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatToggle = document.getElementById('chatToggle');
    const chatWindow = document.getElementById('chatWindow');
    const closeChat = document.getElementById('closeChat');
    const chatForm = document.getElementById('chatForm');
    const messageInput = document.getElementById('messageInput');
    const chatMessages = document.getElementById('chatMessages');
    const clearChat = document.getElementById('clearChat');
    const chatIcon = document.getElementById('chatIcon');
    const suggestedQuestions = document.querySelectorAll('.suggested-question');
    
    // Toggle chat window
    chatToggle.addEventListener('click', function() {
        if (chatWindow.classList.contains('hidden')) {
            // Open chat
            chatWindow.classList.remove('hidden');
            setTimeout(() => {
                chatWindow.classList.remove('scale-95', 'opacity-0');
                chatWindow.classList.add('scale-100', 'opacity-100');
            }, 50);
        } else {
            // No longer using the toggle button to close the chat
            // This keeps the button always in "open chat" mode
        }
    });
    
    // Close chat button (only one way to close now)
    closeChat.addEventListener('click', function() {
        chatWindow.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            chatWindow.classList.add('hidden');
        }, 300);
    });
    
    // Send message
    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (message) {
            addMessage(message, 'user');
            messageInput.value = '';
            
            // Show typing indicator
            showTypingIndicator();
            
            // Send to backend
            fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: message })
            })
            .then(response => response.json())
            .then(data => {
                // Remove typing indicator
                removeTypingIndicator();
                // Add bot response
                setTimeout(() => {
                    addMessage(data.reply, 'bot');
                }, 500);
            })
            .catch(error => {
                // Remove typing indicator
                removeTypingIndicator();
                // Show error
                setTimeout(() => {
                    addMessage('Извините, произошла ошибка. Пожалуйста, попробуйте позже.', 'bot');
                }, 500);
                console.error('Error:', error);
            });
        }
    });
    
    // Clear chat
    clearChat.addEventListener('click', function() {
        // Keep only the welcome message
        const firstMessage = chatMessages.firstElementChild;
        chatMessages.innerHTML = '';
        chatMessages.appendChild(firstMessage);
    });
    
    // Handle suggested questions
    suggestedQuestions.forEach(question => {
        question.addEventListener('click', function() {
            messageInput.value = question.textContent;
            chatForm.dispatchEvent(new Event('submit'));
        });
    });
    
    // Helper function to add a message to the chat
    function addMessage(text, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'flex items-start' + (sender === 'user' ? ' justify-end' : '');
        
        const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        
        if (sender === 'user') {
            messageDiv.innerHTML = `
                <div class="bg-blue-600 rounded-lg rounded-tr-none p-3 max-w-[80%] shadow-md">
                    <p class="text-white text-sm">${text}</p>
                    <span class="text-xs text-blue-200 block mt-1 text-right">${time}</span>
                </div>
            `;
        } else {
            messageDiv.innerHTML = `
                <div class="flex-shrink-0 bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-robot text-white text-sm"></i>
                </div>
                <div class="bg-gray-700 rounded-lg rounded-tl-none p-3 max-w-[80%] shadow-md">
                    <p class="text-white text-sm">${text}</p>
                    <span class="text-xs text-gray-400 block mt-1">${time}</span>
                </div>
            `;
        }
        
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        
        // Add entrance animation
        messageDiv.style.opacity = '0';
        messageDiv.style.transform = 'translateY(10px)';
        messageDiv.style.transition = 'opacity 300ms, transform 300ms';
        
        setTimeout(() => {
            messageDiv.style.opacity = '1';
            messageDiv.style.transform = 'translateY(0)';
        }, 10);
    }
    
    // Show typing indicator
    function showTypingIndicator() {
        const typingDiv = document.createElement('div');
        typingDiv.id = 'typingIndicator';
        typingDiv.className = 'flex items-start';
        typingDiv.innerHTML = `
            <div class="flex-shrink-0 bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center mr-3">
                <i class="fas fa-robot text-white text-sm"></i>
            </div>
            <div class="bg-gray-700 rounded-lg rounded-tl-none p-3 shadow-md">
                <div class="flex space-x-1">
                    <div class="typing-dot bg-gray-400 w-2 h-2 rounded-full animate-bounce"></div>
                    <div class="typing-dot bg-gray-400 w-2 h-2 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                    <div class="typing-dot bg-gray-400 w-2 h-2 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                </div>
            </div>
        `;
        
        chatMessages.appendChild(typingDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    // Remove typing indicator
    function removeTypingIndicator() {
        const typingIndicator = document.getElementById('typingIndicator');
        if (typingIndicator) {
            typingIndicator.remove();
        }
    }
    
    // Add CSS for animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }
        .animate-bounce {
            animation: bounce 1s infinite;
        }
    `;
    document.head.appendChild(style);
});
</script>