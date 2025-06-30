<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Checkout') }} - Tech Shop</title>
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

    <!-- Оформление заказа -->
    <section class="py-16">
        <div class="container mx-auto">
            <h1 class="text-3xl font-semibold mb-8">{{ __('Checkout') }}</h1>

            @if (session('error'))
                <div class="bg-red-600 text-white p-4 rounded-lg mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <div class="flex flex-col md:flex-row gap-8">
                <!-- Форма -->
                <div class="w-full md:w-1/2 bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-semibold mb-6">{{ __('Your Details') }}</h2>
                    <form action="{{ route('order.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-gray-300 mb-2">{{ __('Name') }}</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full p-2 bg-gray-700 rounded text-white" required>
                            @error('name')
                                <p class="text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-300 mb-2">{{ __('Email') }}</label>
                            <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email ?? '') }}" class="w-full p-2 bg-gray-700 rounded text-white" required>
                            @error('email')
                                <p class="text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="address" class="block text-gray-300 mb-2">{{ __('Address') }}</label>
                            <textarea name="address" id="address" class="w-full p-2 bg-gray-700 rounded text-white" required>{{ old('address') }}</textarea>
                            @error('address')
                                <p class="text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="w-full bg-blue-700 text-white p-3 rounded hover:bg-blue-600 transition">{{ __('Place Order') }}</button>
                    </form>
                </div>

                <!-- Итог заказа -->
                <div class="w-full md:w-1/2 bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-semibold mb-6">{{ __('Order Summary') }}</h2>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-700">
                                <th class="py-4">{{ __('Product') }}</th>
                                <th class="py-4">{{ __('Price') }}</th>
                                <th class="py-4">{{ __('Quantity') }}</th>
                                <th class="py-4">{{ __('Total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $id => $item)
                                <tr class="border-b border-gray-700">
                                    <td class="py-4">{{ $item['name'] }}</td>
                                    <td class="py-4">${{ $item['price'] }}</td>
                                    <td class="py-4">{{ $item['quantity'] }}</td>
                                    <td class="py-4">${{ $item['price'] * $item['quantity'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p class="mt-6 text-xl font-semibold">
                        {{ __('Total') }}: ${{ array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart)) }}
                    </p>
                </div>
            </div>
        </div>
    </section>
    @include('layouts.chat')
</body>
</html>