<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Profile') }} - Tech Shop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="font-inter antialiased bg-gradient-to-br from-gray-900 to-gray-800 text-white min-h-screen">
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

    <!-- Профиль -->
    <section class="py-6 md:py-12 px-4">
        <div class="container mx-auto max-w-5xl">
            <!-- Заголовок и сообщение об успехе -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
                <div class="flex items-center gap-4 mb-4 md:mb-0">
                    <div class="bg-blue-500 w-12 h-12 rounded-full flex items-center justify-center shadow-lg">
                        <i class="fas fa-user-circle text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold">{{ __('Your Profile') }}</h1>
                        <p class="text-gray-400">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <a href="/profile/edit" class="bg-gray-800 hover:bg-gray-700 transition px-4 py-2 rounded-lg flex items-center gap-2 w-max">
                    <i class="fas fa-cog"></i>
                    <span>{{ __('Edit Profile') }}</span>
                </a>
            </div>

            @if (session('success'))
            <div class="bg-green-600/90 backdrop-blur-sm text-white p-4 rounded-lg mb-8 flex items-center gap-2 border border-green-500/50">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <!-- Табы для навигации между секциями -->
            <div class="mb-8 border-b border-gray-700">
                <div class="flex flex-wrap gap-2">
                    <button id="ordersTab" class="px-4 py-3 text-lg font-medium text-blue-500 border-b-2 border-blue-500 focus:outline-none">
                        <i class="fas fa-shopping-bag mr-2"></i>{{ __('Orders') }}
                    </button>
                    <button id="favoritesTab" class="px-4 py-3 text-lg font-medium text-gray-400 hover:text-white focus:outline-none">
                        <i class="fas fa-heart mr-2"></i>{{ __('Favorites') }}
                    </button>
                </div>
            </div>

            <!-- Заказы -->
            <div id="ordersContent" class="bg-gray-800/70 backdrop-blur-sm p-6 rounded-xl shadow-xl border border-gray-700/50 mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">{{ __('Your Orders') }}</h2>
                    <a href="/orders" class="text-blue-400 hover:text-blue-300 transition text-sm">{{ __('View all') }}</a>
                </div>

                @if ($orders->isEmpty())
                <div class="flex flex-col items-center justify-center py-10 text-gray-400">
                    <i class="fas fa-shopping-bag text-5xl mb-4 opacity-30"></i>
                    <p class="text-lg">{{ __('No orders yet') }}</p>
                    <a href="/products" class="mt-4 bg-blue-600 hover:bg-blue-500 transition px-6 py-2 rounded-lg text-white flex items-center gap-2">
                        <i class="fas fa-shopping-cart"></i>
                        <span>{{ __('Start Shopping') }}</span>
                    </a>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-700">
                                <th class="py-4 px-2 md:px-4 font-semibold">{{ __('Order ID') }}</th>
                                <th class="py-4 px-2 md:px-4 font-semibold">{{ __('Total') }}</th>
                                <th class="py-4 px-2 md:px-4 font-semibold">{{ __('Status') }}</th>
                                <th class="py-4 px-2 md:px-4 font-semibold">{{ __('Date') }}</th>
                                <th class="py-4 px-2 md:px-4 font-semibold"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr class="border-b border-gray-700 hover:bg-gray-700/30 transition">
                                <td class="py-4 px-2 md:px-4">#{{ $order->id }}</td>
                                <td class="py-4 px-2 md:px-4 font-medium">${{ $order->total }}</td>
                                <td class="py-4 px-2 md:px-4">
                                    @if($order->status == 'completed')
                                    <span class="bg-green-500/20 text-green-400 text-xs px-2 py-1 rounded-full">
                                        {{ $order->status }}
                                    </span>
                                    @elseif($order->status == 'processing')
                                    <span class="bg-blue-500/20 text-blue-400 text-xs px-2 py-1 rounded-full">
                                        {{ $order->status }}
                                    </span>
                                    @elseif($order->status == 'cancelled')
                                    <span class="bg-red-500/20 text-red-400 text-xs px-2 py-1 rounded-full">
                                        {{ $order->status }}
                                    </span>
                                    @else
                                    <span class="bg-gray-500/20 text-gray-400 text-xs px-2 py-1 rounded-full">
                                        {{ $order->status }}
                                    </span>
                                    @endif
                                </td>
                                <td class="py-4 px-2 md:px-4 text-gray-400">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                <td class="py-4 px-2 md:px-4 text-right">
                                    <a href="/orders/{{ $order->id }}" class="text-blue-400 hover:text-blue-300 transition">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

            <!-- Избранное -->
            <div id="favoritesContent" class="bg-gray-800/70 backdrop-blur-sm p-6 rounded-xl shadow-xl border border-gray-700/50 hidden">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">{{ __('Your Favorites') }}</h2>
                </div>

                @if ($favorites->isEmpty())
                <div class="flex flex-col items-center justify-center py-10 text-gray-400">
                    <i class="fas fa-heart text-5xl mb-4 opacity-30"></i>
                    <p class="text-lg">{{ __('No favorites yet') }}</p>
                    <a href="/products" class="mt-4 bg-blue-600 hover:bg-blue-500 transition px-6 py-2 rounded-lg text-white flex items-center gap-2">
                        <i class="fas fa-shopping-cart"></i>
                        <span>{{ __('Explore Products') }}</span>
                    </a>
                </div>
                @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($favorites as $favorite)
                    <div class="bg-gray-700/50 rounded-xl shadow-lg hover:shadow-xl transition group border border-gray-600/30 overflow-hidden">
                        <div class="relative">
                            <img src="{{ $favorite->product->image }}" alt="{{ $favorite->product->name }}" class="w-full h-48 object-contain">
                            <form action="{{ route('profile.remove-favorite') }}" method="POST" class="absolute top-3 right-3">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $favorite->product_id }}">
                                <button type="submit" class="bg-gray-800/70 hover:bg-gray-700 transition w-8 h-8 rounded-full flex items-center justify-center text-red-400 hover:text-red-300">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>

                            @if(isset($favorite->product->discount_price) && $favorite->product->discount_price < $favorite->product->price)
                                <div class="absolute top-3 left-3 bg-red-500 text-white px-2 py-1 rounded-lg text-xs font-bold">
                                    -{{ round((1 - $favorite->product->discount_price / $favorite->product->price) * 100) }}%
                                </div>
                                @endif
                        </div>

                        <div class="p-4">
                            <h3 class="text-lg font-semibold truncate mb-1">{{ $favorite->product->name }}</h3>

                            <div class="flex items-center text-yellow-500 mb-2 text-sm">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="ml-1 text-gray-400">(4.5)</span>
                            </div>

                            <div class="mb-4">
                                @if(isset($favorite->product->discount_price) && $favorite->product->discount_price < $favorite->product->price)
                                    <span class="line-through text-gray-500 mr-2">${{ $favorite->product->price }}</span>
                                    <span class="font-bold">${{ $favorite->product->discount_price }}</span>
                                    @else
                                    <span class="font-bold">${{ $favorite->product->price }}</span>
                                    @endif
                            </div>

                            <div class="flex gap-2">
                                <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $favorite->product_id }}">
                                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 transition px-3 py-2 rounded text-white flex items-center justify-center gap-1 text-sm">
                                        <i class="fas fa-shopping-cart"></i>
                                        <span>{{ __('Add to Cart') }}</span>
                                    </button>
                                </form>

                                <a href="/products/{{ $favorite->product_id }}" class="bg-gray-600 hover:bg-gray-500 transition p-2 rounded">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </section>

    @include('layouts.chat')

    <script>
        // Мобильное меню
        document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        });

        // Мобильное меню языков
        document.getElementById('mobileLangBtn')?.addEventListener('click', function() {
            const langMenu = document.getElementById('mobileLangMenu');
            langMenu.classList.toggle('hidden');
        });

        // Табы
        const ordersTab = document.getElementById('ordersTab');
        const favoritesTab = document.getElementById('favoritesTab');
        const ordersContent = document.getElementById('ordersContent');
        const favoritesContent = document.getElementById('favoritesContent');

        ordersTab?.addEventListener('click', function() {
            ordersTab.classList.add('text-blue-500', 'border-b-2', 'border-blue-500');
            ordersTab.classList.remove('text-gray-400');

            favoritesTab.classList.remove('text-blue-500', 'border-b-2', 'border-blue-500');
            favoritesTab.classList.add('text-gray-400');

            ordersContent.classList.remove('hidden');
            favoritesContent.classList.add('hidden');
        });

        favoritesTab?.addEventListener('click', function() {
            favoritesTab.classList.add('text-blue-500', 'border-b-2', 'border-blue-500');
            favoritesTab.classList.remove('text-gray-400');

            ordersTab.classList.remove('text-blue-500', 'border-b-2', 'border-blue-500');
            ordersTab.classList.add('text-gray-400');

            favoritesContent.classList.remove('hidden');
            ordersContent.classList.add('hidden');
        });
    </script>
</body>

</html>