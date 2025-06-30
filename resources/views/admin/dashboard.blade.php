@extends('admin.admin')

@section('title', __('Dashboard'))

@section('content')
    <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl border border-gray-700/50 shadow-lg p-6 mb-6">
        <h2 class="text-2xl font-semibold mb-2">{{ __('Welcome back') }}, {{ auth()->user()->name }}!</h2>
        <p class="text-gray-400">{{ __('Here\'s what\'s happening with your store today.') }}</p>
    </div>

    <!-- Статистика -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gray-800/60 backdrop-blur-sm rounded-xl border border-gray-700/50 shadow-lg p-6 hover:shadow-blue-500/5 transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-300">{{ __('Total Products') }}</h3>
                <span class="bg-blue-500/20 text-blue-400 p-2 rounded-lg">
                    <i class="fas fa-boxes"></i>
                </span>
            </div>
            <p class="text-3xl font-bold">{{ $productsCount }}</p>
            <div class="mt-4 text-sm text-green-400">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>12% {{ __('from last month') }}</span>
            </div>
        </div>
        
        <div class="bg-gray-800/60 backdrop-blur-sm rounded-xl border border-gray-700/50 shadow-lg p-6 hover:shadow-indigo-500/5 transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-300">{{ __('Total Orders') }}</h3>
                <span class="bg-indigo-500/20 text-indigo-400 p-2 rounded-lg">
                    <i class="fas fa-shopping-cart"></i>
                </span>
            </div>
            <p class="text-3xl font-bold">{{ $ordersCount }}</p>
            <div class="mt-4 text-sm text-green-400">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>8% {{ __('from last month') }}</span>
            </div>
        </div>
        
        <div class="bg-gray-800/60 backdrop-blur-sm rounded-xl border border-gray-700/50 shadow-lg p-6 hover:shadow-amber-500/5 transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-300">{{ __('Pending Orders') }}</h3>
                <span class="bg-amber-500/20 text-amber-400 p-2 rounded-lg">
                    <i class="fas fa-clock"></i>
                </span>
            </div>
            <p class="text-3xl font-bold">{{ $pendingOrders }}</p>
            <div class="mt-4 text-sm text-red-400">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>3% {{ __('from last week') }}</span>
            </div>
        </div>
        
        <div class="bg-gray-800/60 backdrop-blur-sm rounded-xl border border-gray-700/50 shadow-lg p-6 hover:shadow-green-500/5 transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-300">{{ __('Revenue') }}</h3>
                <span class="bg-green-500/20 text-green-400 p-2 rounded-lg">
                    <i class="fas fa-dollar-sign"></i>
                </span>
            </div>
            <p class="text-3xl font-bold">${{ number_format($pendingOrders * 100, 2) }}</p>
            <div class="mt-4 text-sm text-green-400">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>15% {{ __('from last month') }}</span>
            </div>
        </div>
    </div>
    
    <!-- Графики и таблицы -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Продажи за неделю -->
        <div class="lg:col-span-2 bg-gray-800/60 backdrop-blur-sm rounded-xl border border-gray-700/50 shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-medium">{{ __('Weekly Sales') }}</h3>
                <div class="flex items-center space-x-2">
                    <button class="text-sm bg-gray-700 hover:bg-gray-600 px-3 py-1 rounded">{{ __('Week') }}</button>
                    <button class="text-sm bg-gray-700/50 hover:bg-gray-600 px-3 py-1 rounded">{{ __('Month') }}</button>
                    <button class="text-sm bg-gray-700/50 hover:bg-gray-600 px-3 py-1 rounded">{{ __('Year') }}</button>
                </div>
            </div>
            <div class="h-80 bg-gray-700/30 rounded-lg flex items-center justify-center">
                <p class="text-gray-400">{{ __('Sales chart will be displayed here') }}</p>
            </div>
        </div>
        
        <!-- Недавние заказы -->
        <div class="bg-gray-800/60 backdrop-blur-sm rounded-xl border border-gray-700/50 shadow-lg p-6">
            <h3 class="text-lg font-medium mb-6">{{ __('Recent Orders') }}</h3>
            <div class="space-y-4">
                @for ($i = 0; $i < 5; $i++)
                <div class="flex items-center justify-between p-3 bg-gray-700/30 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="bg-blue-500/20 p-2 rounded-lg">
                            <i class="fas fa-shopping-bag text-blue-400"></i>
                        </div>
                        <div>
                            <p class="font-medium">{{ __('Order') }} #{{ 1000 + $i }}</p>
                            <p class="text-sm text-gray-400">{{ now()->subHours($i)->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>
                    <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-lg text-sm">
                        ${{ rand(50, 500) }}
                    </span>
                </div>
                @endfor
                
                <a href="{{ route('admin.orders') }}" class="block text-center text-blue-400 hover:text-blue-300 transition mt-4">
                    {{ __('View All Orders') }} <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Активность и задачи -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-gray-800/60 backdrop-blur-sm rounded-xl border border-gray-700/50 shadow-lg p-6">
            <h3 class="text-lg font-medium mb-6">{{ __('Recent Activity') }}</h3>
            <div class="space-y-6">
                <div class="relative pl-8 pb-6 border-l border-gray-700">
                    <span class="absolute -left-2 top-0 w-4 h-4 bg-green-500 rounded-full border-2 border-gray-800"></span>
                    <p class="font-medium">{{ __('New product added') }}</p>
                    <p class="text-sm text-gray-400">{{ __('iPhone 14 Pro Max') }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ now()->subMinutes(15)->format('d.m.Y H:i') }}</p>
                </div>
                
                <div class="relative pl-8 pb-6 border-l border-gray-700">
                    <span class="absolute -left-2 top-0 w-4 h-4 bg-blue-500 rounded-full border-2 border-gray-800"></span>
                    <p class="font-medium">{{ __('Order completed') }}</p>
                    <p class="text-sm text-gray-400">{{ __('Order') }} #1034</p>
                    <p class="text-xs text-gray-500 mt-1">{{ now()->subHours(2)->format('d.m.Y H:i') }}</p>
                </div>
                
                <div class="relative pl-8">
                    <span class="absolute -left-2 top-0 w-4 h-4 bg-amber-500 rounded-full border-2 border-gray-800"></span>
                    <p class="font-medium">{{ __('Product updated') }}</p>
                    <p class="text-sm text-gray-400">{{ __('Samsung Galaxy S23') }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ now()->subHours(5)->format('d.m.Y H:i') }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-gray-800/60 backdrop-blur-sm rounded-xl border border-gray-700/50 shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-medium">{{ __('Quick Tasks') }}</h3>
                <button class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded-lg flex items-center text-sm">
                    <i class="fas fa-plus mr-1"></i>
                    {{ __('Add Task') }}
                </button>
            </div>
            
            <div class="space-y-3">
                <div class="flex items-center p-3 bg-gray-700/30 rounded-lg">
                    <input type="checkbox" class="mr-3">
                    <span>{{ __('Update product inventory') }}</span>
                </div>
                <div class="flex items-center p-3 bg-gray-700/30 rounded-lg">
                    <input type="checkbox" class="mr-3">
                    <span>{{ __('Respond to customer inquiries') }}</span>
                </div>
                <div class="flex items-center p-3 bg-gray-700/30 rounded-lg">
                    <input type="checkbox" class="mr-3" checked>
                    <span class="line-through text-gray-400">{{ __('Process pending orders') }}</span>
                </div>
                <div class="flex items-center p-3 bg-gray-700/30 rounded-lg">
                    <input type="checkbox" class="mr-3">
                    <span>{{ __('Plan upcoming promotions') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection