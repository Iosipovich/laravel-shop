<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Shop</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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



    <!-- Hero Banner -->
    <section class="relative overflow-hidden bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="relative h-[500px] md:h-[600px]">
                        <!-- Background Image with Overlay -->
                        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://via.placeholder.com/1920x1080?text=iPhone+Banner')"></div>
                        <div class="absolute inset-0 bg-gradient-to-r from-gray-900/90 via-gray-900/70 to-transparent"></div>

                        <!-- Content -->
                        <div class="container mx-auto h-full flex items-center relative z-10 px-4">
                            <div class="max-w-xl">
                                <span class="inline-block px-3 py-1 bg-blue-600 text-white text-sm font-medium rounded-full mb-4">{{ __('Limited Offer') }}</span>
                                <h1 class="text-4xl md:text-6xl font-bold leading-tight text-white mb-4">{{ __('Discounts up to 20%') }}</h1>
                                <p class="text-lg md:text-xl text-gray-300 mb-8">{{ __('Exclusive deals for registered users. Top brands, premium quality, unbeatable prices.') }}</p>
                                <div class="flex flex-wrap gap-4">
                                    <a href="/register" class="px-8 py-4 bg-blue-600 hover:bg-blue-500 text-white font-medium rounded-lg transition duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-blue-500/30">
                                        {{ __('Join Now') }}
                                    </a>
                                    <a href="/products" class="px-8 py-4 bg-gray-800 hover:bg-gray-700 text-white font-medium rounded-lg transition duration-300 transform hover:-translate-y-1 shadow-lg">
                                        {{ __('Explore Products') }}
                                    </a>
                                </div>

                                <!-- Countdown Timer -->
                                <div class="mt-8 flex items-center space-x-2 text-gray-300">
                                    <i class="fas fa-clock"></i>
                                    <span>{{ __('Offer ends in:') }}</span>
                                    <div class="font-mono bg-gray-800 px-2 py-1 rounded">23</div>:
                                    <div class="font-mono bg-gray-800 px-2 py-1 rounded">12</div>:
                                    <div class="font-mono bg-gray-800 px-2 py-1 rounded">45</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="relative h-[500px] md:h-[600px]">
                        <!-- Background Image with Overlay -->
                        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://via.placeholder.com/1920x1080?text=Samsung+Banner')"></div>
                        <div class="absolute inset-0 bg-gradient-to-r from-gray-900/90 via-gray-900/70 to-transparent"></div>

                        <!-- Content -->
                        <div class="container mx-auto h-full flex items-center relative z-10 px-4">
                            <div class="max-w-xl">
                                <span class="inline-block px-3 py-1 bg-indigo-600 text-white text-sm font-medium rounded-full mb-4">{{ __('New Arrival') }}</span>
                                <h1 class="text-4xl md:text-6xl font-bold leading-tight text-white mb-4">{{ __('New Samsung Galaxy') }}</h1>
                                <p class="text-lg md:text-xl text-gray-300 mb-8">{{ __('Experience cutting-edge technology with the latest Samsung flagship devices.') }}</p>
                                <div class="flex flex-wrap gap-4">
                                    <a href="/products" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-medium rounded-lg transition duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-indigo-500/30">
                                        {{ __('Shop Now') }}
                                    </a>
                                    <a href="/products" class="px-8 py-4 bg-gray-800 hover:bg-gray-700 text-white font-medium rounded-lg transition duration-300 transform hover:-translate-y-1 shadow-lg">
                                        {{ __('Learn More') }}
                                    </a>
                                </div>

                                <!-- Features -->
                                <div class="mt-8 flex space-x-6">
                                    <div class="flex items-center space-x-2 text-gray-300">
                                        <i class="fas fa-microchip text-indigo-400"></i>
                                        <span>{{ __('Fast Processor') }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-gray-300">
                                        <i class="fas fa-camera text-indigo-400"></i>
                                        <span>{{ __('108MP Camera') }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-gray-300">
                                        <i class="fas fa-battery-full text-indigo-400"></i>
                                        <span>{{ __('5000mAh') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Пагинация и навигация слайдера -->
            <div class="swiper-pagination absolute bottom-6 z-20"></div>
            <div class="container mx-auto px-4">
            </div>
        </div>
    </section>

    <!-- Категории -->
    <section class="py-12 md:py-16 bg-gradient-to-b from-gray-950 to-gray-900">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-white">{{ __('Categories') }}</h2>
                <a href="/products" class="flex items-center space-x-1 text-blue-400 hover:text-blue-300 transition duration-300">
                    <span>{{ __('View All') }}</span>
                    <i class="fas fa-chevron-right text-xs"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 md:gap-6">
                @foreach ($categories as $category)
                <a href="/products?category={{ $category->id }}" class="group relative overflow-hidden bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition duration-300 ease-in-out">
                    <!-- Иконка категории -->
                    <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-t from-gray-900 to-transparent opacity-70"></div>
                    <div class="p-6 md:p-8 flex flex-col items-center justify-center h-[140px] transition-all duration-300 group-hover:scale-105">
                        <i class="fas fa-mobile-alt text-4xl text-blue-400 mb-4 transition-all duration-300 group-hover:scale-110 group-hover:text-blue-300"></i>
                        <h3 class="text-lg font-semibold text-white text-center relative z-10">{{ $category->name }}</h3>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Популярные товары - улучшено -->
    <section class="py-12 md:py-16 bg-gray-900">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-white">{{ __('Popular Products') }}</h2>
                <a href="/products" class="flex items-center space-x-1 text-blue-400 hover:text-blue-300 transition duration-300">
                    <span>{{ __('View All Products') }}</span>
                    <i class="fas fa-chevron-right text-xs"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
                @foreach ($products as $product)
                <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden group hover:shadow-blue-500/5 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                    <div class="relative overflow-hidden h-48 md:h-56">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <div class="p-5">
                        <!-- ... -->
                        <div class="flex items-center space-x-2">
                            <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white flex items-center justify-center space-x-2 px-4 py-2 rounded-lg transition duration-300">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span>{{ __('Add to Cart') }}</span>
                                </button>
                            </form>
                            @auth
                            <form action="{{ route('favorites.toggle') }}" method="POST" class="favorite-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="favorite-btn bg-gray-700 hover:bg-gray-600 transition duration-300 p-2 rounded-lg shadow-md">
                                    <i class="{{ $product->isFavorited ? 'fas text-red-500' : 'far text-white' }} fa-heart"></i>
                                </button>
                            </form>
                            @endauth
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-12 bg-gray-950">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="flex items-center space-x-4 p-6 bg-gray-800/50 rounded-xl border border-gray-700/30 backdrop-blur-sm transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-blue-500/5">
                    <div class="text-3xl text-blue-500">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg text-white">{{ __('Free Shipping') }}</h3>
                        <p class="text-gray-400 text-sm">{{ __('For orders over $100') }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4 p-6 bg-gray-800/50 rounded-xl border border-gray-700/30 backdrop-blur-sm transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-blue-500/5">
                    <div class="text-3xl text-blue-500">
                        <i class="fas fa-undo"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg text-white">{{ __('Easy Returns') }}</h3>
                        <p class="text-gray-400 text-sm">{{ __('30-day return policy') }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4 p-6 bg-gray-800/50 rounded-xl border border-gray-700/30 backdrop-blur-sm transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-blue-500/5">
                    <div class="text-3xl text-blue-500">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg text-white">{{ __('Secure Payment') }}</h3>
                        <p class="text-gray-400 text-sm">{{ __('100% secure checkout') }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4 p-6 bg-gray-800/50 rounded-xl border border-gray-700/30 backdrop-blur-sm transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-blue-500/5">
                    <div class="text-3xl text-blue-500">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg text-white">{{ __('24/7 Support') }}</h3>
                        <p class="text-gray-400 text-sm">{{ __('Dedicated support team') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @include('layouts.chat')
</body>

</html>