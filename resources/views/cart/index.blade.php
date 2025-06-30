<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Cart') }} - Tech Shop</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="font-inter antialiased bg-gray-900 text-white">
    <!-- Навигация -->
    <nav class="bg-gray-900/80 backdrop-blur-sm p-4 sticky top-0 z-20 shadow-lg border-b border-gray-800">
        <div class="container mx-auto">
            <div class="flex justify-between items-center">
                <a href="/" class="text-2xl font-bold text-white hover:text-blue-400 transition flex items-center">
                    <i class="fas fa-microchip text-blue-500 mr-2"></i>
                    <span>Tech Shop</span>
                </a>

                <!-- Мобильное меню -->
                <button id="mobileMenuBtn" class="md:hidden text-white">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Десктопное меню -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="/products" class="text-gray-300 hover:text-white transition flex items-center gap-1">
                        <i class="fas fa-laptop"></i>
                        <span>{{ __('Products') }}</span>
                    </a>
                    <a href="/cart" class="text-gray-300 hover:text-white transition flex items-center gap-1 relative">
                        <i class="fas fa-shopping-cart"></i>
                        <span>{{ __('Cart') }}</span>
                    </a>

                    <div class="relative group">
                        <button class="flex items-center gap-1 text-gray-300 hover:text-white transition">
                            <i class="fas fa-globe"></i>
                            <span>{{ app()->getLocale() == 'ru' ? 'RU' : 'RO' }}</span>
                            <i class="fas fa-chevron-down text-xs ml-1"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-32 bg-gray-800 border border-gray-700 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-30">
                            <a href="/lang/ru" class="block px-4 py-2 hover:bg-gray-700 rounded-t-lg {{ app()->getLocale() == 'ru' ? 'bg-gray-700' : '' }}">Русский</a>
                            <a href="/lang/ro" class="block px-4 py-2 hover:bg-gray-700 rounded-b-lg {{ app()->getLocale() == 'ro' ? 'bg-gray-700' : '' }}">Română</a>
                        </div>
                    </div>

                    @auth
                    <div class="relative group">
                        <button class="flex items-center gap-1 text-gray-300 hover:text-white transition">
                            <i class="fas fa-user-circle"></i>
                            <span>{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs ml-1"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-40 bg-gray-800 border border-gray-700 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-30">
                            <a href="{{ route('profile.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-t-lg flex items-center gap-2">
                                <i class="fas fa-user text-blue-500"></i>
                                <span>{{ __('Profile') }}</span>
                            </a>
                            <form action="/logout" method="POST" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-700 rounded-b-lg flex items-center gap-2 text-red-400">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>{{ __('Logout') }}</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="/login" class="text-gray-300 hover:text-white transition flex items-center gap-1">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>{{ __('Login') }}</span>
                    </a>
                    <a href="/register" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg transition duration-300 flex items-center gap-1 shadow-md hover:shadow-blue-500/30">
                        <i class="fas fa-user-plus"></i>
                        <span>{{ __('Register') }}</span>
                    </a>
                    @endauth
                </div>
            </div>

            <!-- Мобильное выпадающее меню -->
            <div id="mobileMenu" class="md:hidden mt-4 pb-2 hidden bg-gray-800/95 rounded-lg shadow-xl transition-all duration-300 transform origin-top">
                <div class="flex flex-col space-y-3 border-t border-gray-800 pt-3 px-4">
                    <a href="/products" class="text-gray-300 hover:text-white transition flex items-center gap-2 py-2">
                        <i class="fas fa-laptop w-6"></i>
                        <span>{{ __('Products') }}</span>
                    </a>
                    <a href="/cart" class="text-gray-300 hover:text-white transition flex items-center gap-2 py-2 relative">
                        <i class="fas fa-shopping-cart w-6"></i>
                        <span>{{ __('Cart') }}</span>
                    </a>

                    <div class="py-2">
                        <button id="mobileLangBtn" class="flex items-center gap-2 text-gray-300 hover:text-white transition w-full justify-between">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-globe w-6"></i>
                                <span>{{ __('Language') }}</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div id="mobileLangMenu" class="hidden mt-2 ml-8 bg-gray-800 rounded border border-gray-700 shadow-md">
                            <a href="/lang/ru" class="block px-4 py-2 hover:bg-gray-700 {{ app()->getLocale() == 'ru' ? 'bg-gray-700' : '' }}">Русский</a>
                            <a href="/lang/ro" class="block px-4 py-2 hover:bg-gray-700 {{ app()->getLocale() == 'ro' ? 'bg-gray-700' : '' }}">Română</a>
                        </div>
                    </div>

                    @auth
                    <a href="{{ route('profile.index') }}" class="text-gray-300 hover:text-white transition flex items-center gap-2 py-2">
                        <i class="fas fa-user w-6"></i>
                        <span>{{ __('Profile') }}</span>
                    </a>
                    <form action="/logout" method="POST" class="block">
                        @csrf
                        <button type="submit" class="text-red-400 hover:text-red-300 flex items-center gap-2 py-2 w-full">
                            <i class="fas fa-sign-out-alt w-6"></i>
                            <span>{{ __('Logout') }}</span>
                        </button>
                    </form>
                    @else
                    <a href="/login" class="text-gray-300 hover:text-white transition flex items-center gap-2 py-2">
                        <i class="fas fa-sign-in-alt w-6"></i>
                        <span>{{ __('Login') }}</span>
                    </a>
                    <a href="/register" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg transition duration-300 flex items-center gap-2 justify-start shadow-md hover:shadow-blue-500/30">
                        <i class="fas fa-user-plus w-6"></i>
                        <span>{{ __('Register') }}</span>
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Обновленная корзина -->
    <section class="py-8 md:py-16 flex-grow">
        <div class="container mx-auto px-4">
            <h1 class="text-2xl md:text-3xl font-bold mb-4 md:mb-8 flex items-center">
                <i class="fas fa-shopping-cart text-blue-500 mr-3"></i>
                {{ __('Your Shopping Cart') }}
            </h1>

            @if (session('success'))
            <div class="bg-green-600/90 backdrop-blur-sm text-white p-4 rounded-lg mb-6 flex items-center shadow-lg border border-green-500/30 animate-fadeIn">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
            @endif

            @if (empty($cart))
            <div class="bg-gray-800/80 backdrop-blur-sm rounded-xl p-8 shadow-xl border border-gray-700/50 text-center">
                <div class="flex flex-col items-center">
                    <i class="fas fa-shopping-cart text-gray-500 text-5xl mb-4"></i>
                    <p class="text-gray-400 text-xl mb-6">{{ __('Your cart is empty') }}</p>
                    <a href="/products" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-lg transition duration-300 flex items-center gap-2 shadow-lg">
                        <i class="fas fa-laptop"></i>
                        <span>{{ __('Browse Products') }}</span>
                    </a>
                </div>
            </div>
            @else
            <div class="bg-gray-800/90 backdrop-blur-sm rounded-xl shadow-xl border border-gray-700/50 overflow-hidden">
                <!-- Заголовок для мобильных устройств -->
                <div class="bg-gray-800 p-4 border-b border-gray-700 md:hidden">
                    <h2 class="font-semibold">{{ __('Your Items') }}</h2>
                </div>

                <!-- Десктопная таблица (скрыта на мобильных) -->
                <div class="hidden md:block">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-800/90">
                                <th class="p-4 font-semibold">{{ __('Product') }}</th>
                                <th class="p-4 font-semibold">{{ __('Price') }}</th>
                                <th class="p-4 font-semibold">{{ __('Quantity') }}</th>
                                <th class="p-4 font-semibold">{{ __('Total') }}</th>
                                <th class="p-4 w-24"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700/50">
                            @foreach ($cart as $id => $item)
                            <tr class="hover:bg-gray-700/30 transition duration-150" data-product-id="{{ $id }}">
                                <td class="p-4">
                                    <div class="flex items-center space-x-4">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-16 h-16 rounded-lg object-contain bg-gray-700/30 p-2">
                                        <span class="font-medium">{{ $item['name'] }}</span>
                                    </div>
                                </td>
                                <td class="p-4 text-blue-400">${{ $item['price'] }}</td>
                                <td class="p-4">
                                    <form action="{{ route('cart.update') }}" method="POST" class="flex items-center quantity-form">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $id }}">
                                        <div class="flex items-center border border-gray-600 rounded-lg overflow-hidden">
                                            <button type="button" class="quantity-decrease px-3 py-2 bg-gray-700 hover:bg-gray-600 transition">
                                                <i class="fas fa-minus text-sm"></i>
                                            </button>
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-14 p-2 bg-transparent text-center focus:outline-none quantity-input">
                                            <button type="button" class="quantity-increase px-3 py-2 bg-gray-700 hover:bg-gray-600 transition">
                                                <i class="fas fa-plus text-sm"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                                <td class="p-4 font-medium">
                                    <span class="item-total">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                </td>
                                <td class="p-4">
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $id }}">
                                        <button type="submit" class="text-red-400 hover:text-red-300 transition p-2 rounded-full hover:bg-red-500/10">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Мобильный список (скрыт на десктопе) -->
                <div class="md:hidden divide-y divide-gray-700/50">
                    @foreach ($cart as $id => $item)
                    <div class="p-4 space-y-3" data-product-id="{{ $id }}">
                        <div class="flex items-start space-x-3">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-20 h-20 rounded-lg object-contain bg-gray-700/30 p-2">
                            <div class="flex-1">
                                <h3 class="font-medium">{{ $item['name'] }}</h3>
                                <p class="text-blue-400 my-1">${{ $item['price'] }}</p>
                                <div class="flex items-center justify-between">
                                    <p class="font-medium">Total: <span class="text-blue-400 item-total">${{ number_format($item['price'] * $item['quantity'], 2) }}</span></p>
                                    <form action="{{ route('cart.remove') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $id }}">
                                        <button type="submit" class="text-red-400 hover:text-red-300 transition p-2 rounded-full hover:bg-red-500/10">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('cart.update') }}" method="POST" class="flex items-center justify-center mt-2 quantity-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $id }}">
                            <div class="flex items-center border border-gray-600 rounded-lg overflow-hidden">
                                <button type="button" class="quantity-decrease px-3 py-2 bg-gray-700 hover:bg-gray-600 transition">
                                    <i class="fas fa-minus text-sm"></i>
                                </button>
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-14 p-2 bg-transparent text-center focus:outline-none quantity-input">
                                <button type="button" class="quantity-increase px-3 py-2 bg-gray-700 hover:bg-gray-600 transition">
                                    <i class="fas fa-plus text-sm"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    @endforeach
                </div>

                <!-- Итоговая информация - исправленная версия -->
                <div class="border-t border-gray-700">
                    <div class="p-6 space-y-4">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div class="space-y-1 w-full md:w-auto">
                                <div class="flex justify-between md:block">
                                    <p class="text-gray-400">{{ __('Subtotal') }}:</p>
                                    <p class="font-medium md:text-lg cart-subtotal">
                                        ${{ number_format(collect($cart)->sum(function($item) {
                            return $item['price'] * $item['quantity'];
                        }), 2) }}
                                    </p>
                                </div>
                                <div class="flex justify-between md:block">
                                    <p class="text-gray-400">{{ __('Shipping') }}:</p>
                                    <p class="font-medium md:text-lg">$0.00</p>
                                </div>
                            </div>

                            <div class="bg-gray-700/30 p-4 rounded-lg w-full md:w-auto md:ml-auto">
                                <div class="flex justify-between items-center">
                                    <p class="text-xl font-bold">{{ __('Total') }}:</p>
                                    <p class="text-xl font-bold text-blue-400 cart-total">
                                        ${{ number_format(collect($cart)->sum(function($item) {
                            return $item['price'] * $item['quantity'];
                        }), 2) }}
                                    </p>
                                </div>
                                <div class="flex flex-col sm:flex-row gap-3 mt-4">
                                    <a href="/products" class="text-white px-6 py-3 rounded-lg border border-gray-600 hover:bg-gray-700 transition text-center">
                                        {{ __('Continue Shopping') }}
                                    </a>
                                    <a href="{{ route('checkout') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-500 transition duration-300 shadow-lg hover:shadow-blue-500/20 text-center flex-1 flex items-center justify-center">
                                        <i class="fas fa-credit-card mr-2"></i>
                                        {{ __('Checkout') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>

    @include('layouts.chat')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initial calculation of totals when page loads
            calculateCartTotals();

            // Add event listeners to all decrease buttons
            document.querySelectorAll('.quantity-decrease').forEach(button => {
                button.addEventListener('click', function() {
                    decreaseQuantity(this);
                });
            });

            // Add event listeners to all increase buttons
            document.querySelectorAll('.quantity-increase').forEach(button => {
                button.addEventListener('click', function() {
                    increaseQuantity(this);
                });
            });

            // Handle direct input changes
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    const form = this.closest('.quantity-form');
                    const price = parseFloat(form.closest('tr, div').querySelector('.text-blue-400').textContent.replace('$', ''));

                    // Ensure quantity is at least 1
                    if (parseInt(this.value) < 1) {
                        this.value = 1;
                    }

                    updateItemTotal(form, price);
                    calculateCartTotals();
                    submitQuantityUpdate(form);
                });
            });

            function decreaseQuantity(button) {
                const form = button.closest('.quantity-form');
                const input = form.querySelector('input[name="quantity"]');
                const price = parseFloat(form.closest('tr, div').querySelector('.text-blue-400').textContent.replace('$', ''));

                if (input && parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                    updateItemTotal(form, price);
                    calculateCartTotals();
                    submitQuantityUpdate(form);
                }
            }

            function increaseQuantity(button) {
                const form = button.closest('.quantity-form');
                const input = form.querySelector('input[name="quantity"]');
                const price = parseFloat(form.closest('tr, div').querySelector('.text-blue-400').textContent.replace('$', ''));

                if (input) {
                    input.value = parseInt(input.value) + 1;
                    updateItemTotal(form, price);
                    calculateCartTotals();
                    submitQuantityUpdate(form);
                }
            }

            // Update only the individual item total
            function updateItemTotal(form, price) {
                const quantity = parseInt(form.querySelector('input[name="quantity"]').value);
                const itemTotal = form.closest('tr, div').querySelector('.item-total');

                if (itemTotal) {
                    itemTotal.textContent = '$' + (price * quantity).toFixed(2);
                }
            }

            function calculateCartTotals() {
                const allItems = document.querySelectorAll('.item-total');
                let subtotal = 0;

                allItems.forEach(item => {
                    const itemValue = parseFloat(item.textContent.replace('$', ''));
                    if (!isNaN(itemValue)) {
                        subtotal += itemValue;
                    }
                });

                const subtotalElements = document.querySelectorAll('.cart-subtotal');
                const totalElements = document.querySelectorAll('.cart-total');

                subtotalElements.forEach(element => {
                    element.textContent = '$' + subtotal.toFixed(2);
                });

                totalElements.forEach(element => {
                    element.textContent = '$' + subtotal.toFixed(2);
                });
            }

            // AJAX 
            function submitQuantityUpdate(form) {
                const formData = new FormData(form);
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                if (!csrfToken) {
                    console.error('CSRF token not found');
                    return;
                }

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    }
                }).then(response => {
                    if (!response.ok) throw new Error('Failed to update cart');
                    return response.json();
                }).then(data => {
                    // If the server responds with updated cart data, you can refresh the display
                    if (data && data.success) {
                        calculateCartTotals();
                    }
                }).catch(error => {
                    console.error('Error updating cart:', error);
                });
            }
        });
    </script>
</body>

</html>