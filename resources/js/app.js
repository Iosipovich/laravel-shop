import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';

document.addEventListener('DOMContentLoaded', () => {
    // Initialize Swiper slider
    const swiperElement = document.querySelector('.swiper-container');
    if (swiperElement) {
        const swiper = new Swiper(swiperElement, {
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            }
        });
    }

    // Mobile menu toggle
    const mobileMenuButton = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', (e) => {
            e.stopPropagation();
            mobileMenu.classList.toggle('hidden');
            mobileMenu.classList.toggle('scale-y-0');
            mobileMenu.classList.toggle('scale-y-100');
        });

        document.addEventListener('click', (e) => {
            if (!mobileMenuButton.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.add('hidden');
                mobileMenu.classList.add('scale-y-0');
                mobileMenu.classList.remove('scale-y-100');
            }
        });
    }

    // Language dropdown toggle
    const languageDropdown = document.getElementById('language-dropdown');
    const languageMenu = document.getElementById('language-menu');

    if (languageDropdown && languageMenu) {
        languageDropdown.addEventListener('click', (e) => {
            e.stopPropagation();
            languageMenu.classList.toggle('hidden');
            languageMenu.classList.toggle('opacity-0');
            languageMenu.classList.toggle('opacity-100');
        });

        document.addEventListener('click', () => {
            languageMenu.classList.add('hidden');
            languageMenu.classList.add('opacity-0');
            languageMenu.classList.remove('opacity-100');
        });
    }

    // Chat functionality
    const chatContainer = document.getElementById('chat-container');
    const chatToggle = document.getElementById('chat-toggle');
    const chatClose = document.getElementById('chat-close');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const chatMessages = document.getElementById('chat-messages');

    if (chatToggle && chatContainer) {
        chatToggle.addEventListener('click', () => {
            chatContainer.classList.toggle('hidden');
            chatContainer.classList.toggle('opacity-0');
            chatContainer.classList.toggle('opacity-100');
            chatContainer.classList.toggle('translate-y-4');
            if (!chatContainer.classList.contains('hidden') && chatInput) {
                chatInput.focus();
            }
        });
    }

    if (chatClose && chatContainer) {
        chatClose.addEventListener('click', () => {
            chatContainer.classList.add('hidden');
            chatContainer.classList.add('opacity-0');
            chatContainer.classList.remove('opacity-100');
            chatContainer.classList.add('translate-y-4');
        });
    }

    if (chatForm && chatInput && chatMessages) {
        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = chatInput.value.trim();
            if (!message) return;

            appendMessage(message, 'user');

            try {
                const response = await fetch('/chat/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ message }),
                });

                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();
                appendMessage(data.reply, 'bot');
            } catch (error) {
                console.error('Chat error:', error);
                appendMessage('Sorry, there was an error. Please try again.', 'bot');
            }

            chatInput.value = '';
            chatInput.focus();
            chatMessages.scrollTop = chatMessages.scrollHeight;
        });

        function appendMessage(text, sender) {
            const messageDiv = document.createElement('div');
            messageDiv.classList.add('mb-2', 'p-2', 'rounded-lg', 'max-w-[80%', 'break-words');
            if (sender === 'user') {
                messageDiv.classList.add('ml-auto', 'bg-blue-600', 'text-white');
            } else {
                messageDiv.classList.add('mr-auto', 'bg-gray-700', 'text-white');
            }
            messageDiv.textContent = text;
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    }

    // Add to cart functionality with animation
    const addToCartButtons = document.querySelectorAll('button[type="submit"]:not(#chat-form button)');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            this.classList.add('animate-bounce');
            setTimeout(() => this.classList.remove('animate-bounce'), 500);
        });
    });

    // Favorite functionality
    const favoriteButtons = document.querySelectorAll('.favorite-btn');
    favoriteButtons.forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();
            const form = button.closest('form');
            const productId = form.querySelector('input[name="product_id"]').value;

            try {
                const response = await fetch('/favorites/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ product_id: productId }),
                });

                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();
                if (data.success) {
                    const heartIcon = button.querySelector('i');
                    if (data.isFavorited) {
                        heartIcon.classList.remove('far', 'text-white');
                        heartIcon.classList.add('fas', 'text-red-500');
                    } else {
                        heartIcon.classList.remove('fas', 'text-red-500');
                        heartIcon.classList.add('far', 'text-white');
                    }
                }
            } catch (error) {
                console.error('Favorite toggle error:', error);
            }
        });
    });

    // Countdown timer
    const countdownElements = document.querySelectorAll('.font-mono.bg-gray-800');
    if (countdownElements.length === 3) {
        let hours = parseInt(countdownElements[0].textContent);
        let minutes = parseInt(countdownElements[1].textContent);
        let seconds = parseInt(countdownElements[2].textContent);

        const updateCountdown = () => {
            seconds--;
            if (seconds < 0) {
                seconds = 59;
                minutes--;
                if (minutes < 0) {
                    minutes = 59;
                    hours--;
                    if (hours < 0) hours = 23;
                }
            }
            countdownElements[0].textContent = String(hours).padStart(2, '0');
            countdownElements[1].textContent = String(minutes).padStart(2, '0');
            countdownElements[2].textContent = String(seconds).padStart(2, '0');
        };
        setInterval(updateCountdown, 1000);
    }
});

// Переключение вида товаров (сетка/список)
const productGrid = document.getElementById('product-grid');

document.querySelector('.grid-view-btn')?.addEventListener('click', function() {
    this.classList.replace('text-gray-400', 'text-blue-500');
    document.querySelector('.list-view-btn').classList.replace('text-blue-500', 'text-gray-400');

    if (productGrid) {
        productGrid.classList.remove('grid-cols-1');
        productGrid.classList.add('sm:grid-cols-2', 'lg:grid-cols-3');
    }
});

document.querySelector('.list-view-btn')?.addEventListener('click', function() {
    this.classList.replace('text-gray-400', 'text-blue-500');
    document.querySelector('.grid-view-btn').classList.replace('text-blue-500', 'text-gray-400');

    if (productGrid) {
        productGrid.classList.remove('sm:grid-cols-2', 'lg:grid-cols-3');
        productGrid.classList.add('grid-cols-1');
    }
});