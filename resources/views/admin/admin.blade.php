<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Admin Panel') }} - Tech Shop</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="font-inter antialiased bg-gray-900 text-white">
    <div class="flex min-h-screen">
        <!-- Боковое меню -->
        <aside class="w-64 bg-gray-800/80 backdrop-blur-sm border-r border-gray-700/50 shadow-xl transition-all duration-300">
            <div class="p-6">
                <a href="/" class="text-2xl font-bold text-white hover:text-blue-400 transition flex items-center mb-8">
                    <i class="fas fa-microchip text-blue-500 mr-2"></i>
                    <span>Tech Shop</span>
                </a>
                
                <div class="mb-8">
                    <div class="px-4 py-3 bg-gray-700/50 rounded-lg flex items-center mb-6">
                        <div class="bg-blue-500 p-2 rounded-full mr-3">
                            <i class="fas fa-user-shield text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-300">{{ __('Logged in as') }}</p>
                            <p class="font-medium">{{ auth()->user()->name }}</p>
                        </div>
                    </div>
                </div>

                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-700/70 rounded-lg transition-all duration-200">
                        <i class="fas fa-chart-line w-5 mr-3 text-blue-500 group-hover:text-blue-400"></i>
                        <span>{{ __('Dashboard') }}</span>
                    </a>
                    <a href="{{ route('admin.products') }}" class="group flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-700/70 rounded-lg transition-all duration-200">
                        <i class="fas fa-boxes w-5 mr-3 text-blue-500 group-hover:text-blue-400"></i>
                        <span>{{ __('Products') }}</span>
                    </a>
                    <a href="{{ route('admin.orders') }}" class="group flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-700/70 rounded-lg transition-all duration-200">
                        <i class="fas fa-shopping-cart w-5 mr-3 text-blue-500 group-hover:text-blue-400"></i>
                        <span>{{ __('Orders') }}</span>
                    </a>
                    
                    <div class="pt-4 mt-4 border-t border-gray-700/50">
                        <a href="/" class="group flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-700/70 rounded-lg transition-all duration-200">
                            <i class="fas fa-home w-5 mr-3 text-gray-400 group-hover:text-gray-300"></i>
                            <span>{{ __('View Site') }}</span>
                        </a>
                        <form action="/logout" method="POST" class="mt-1">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-4 py-3 text-red-400 hover:text-red-300 hover:bg-gray-700/70 rounded-lg transition-all duration-200">
                                <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                                <span>{{ __('Logout') }}</span>
                            </button>
                        </form>
                    </div>
                </nav>
            </div>
        </aside>

        <!-- Контент -->
        <main class="flex-1 flex flex-col">
            <!-- Верхняя навигация -->
            <header class="bg-gray-800/80 backdrop-blur-sm border-b border-gray-700/50 shadow-lg z-10">
                <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                    <h1 class="text-xl font-semibold">@yield('title', __('Admin Panel'))</h1>
                    
                    <div class="flex items-center gap-4">
                        <!-- Поиск -->
                        <div class="relative">
                            <input type="text" placeholder="{{ __('Search...') }}" class="bg-gray-700/70 w-64 py-2 px-4 pr-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                            <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                        </div>
                        
                        <!-- Уведомления -->
                        <div class="relative">
                            <button class="p-2 rounded-lg hover:bg-gray-700/70 transition-all relative">
                                <i class="fas fa-bell text-gray-300"></i>
                                <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">3</span>
                            </button>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Основной контент -->
            <div class="flex-1 overflow-auto p-6">
                <div class="container mx-auto">
                    @if (session('success'))
                        <div class="bg-green-600/90 backdrop-blur-sm text-white p-4 rounded-lg mb-6 flex items-center border border-green-500/50 shadow-lg">
                            <i class="fas fa-check-circle mr-3"></i>
                            {{ session('success') }}
                            <button class="ml-auto text-white">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="bg-red-600/90 backdrop-blur-sm text-white p-4 rounded-lg mb-6 flex items-center border border-red-500/50 shadow-lg">
                            <i class="fas fa-exclamation-circle mr-3"></i>
                            {{ session('error') }}
                            <button class="ml-auto text-white">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif
                    
                    @yield('content')
                </div>
            </div>
            
            <!-- Футер -->
            <footer class="bg-gray-800/80 backdrop-blur-sm border-t border-gray-700/50 py-4 px-6 text-center text-gray-400 text-sm">
                <p>© {{ date('Y') }} Tech Shop Admin. {{ __('All rights reserved') }}.</p>
            </footer>
        </main>
    </div>
    
    <script>
        // Скрипт для закрытия уведомлений
        document.addEventListener('DOMContentLoaded', function() {
            const closeButtons = document.querySelectorAll('[class*="bg-"][class*="-600"] button');
            closeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('[class*="bg-"][class*="-600"]').style.display = 'none';
                });
            });
        });
    </script>
</body>
</html>