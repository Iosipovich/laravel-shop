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

<body class="font-inter antialiased bg-gray-900 text-white h-dvh">

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


    <div class="max-h-screen flex items-center justify-center bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-gray-800/70 backdrop-blur-sm p-8 rounded-xl border border-gray-700/30 shadow-2xl">
            <!-- Логотип и заголовок -->
            <div class="text-center">
                <a href="/" class="text-2xl font-bold text-white hover:text-blue-400 transition flex items-center justify-center">
                    <i class="fas fa-microchip text-blue-500 mr-2"></i>
                    <span>Tech Shop</span>
                </a>
                <h2 class="mt-6 text-3xl font-bold text-white">
                    {{ __('Create an Account') }}
                </h2>
                <p class="mt-2 text-sm text-gray-400">
                    {{ __('Join us to unlock exclusive features') }}
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" class="text-gray-100" />
                    <x-text-input
                        id="name"
                        class="block mt-1 w-full bg-gray-700 border border-gray-600 text-white rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required
                        autofocus
                        autocomplete="name"
                    />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400" />
                </div>

                <!-- Email -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" class="text-gray-100" />
                    <x-text-input
                        id="email"
                        class="block mt-1 w-full bg-gray-700 border border-gray-600 text-white rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autocomplete="username"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" class="text-gray-100" />
                    <x-text-input
                        id="password"
                        class="block mt-1 w-full bg-gray-700 border border-gray-600 text-white rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-100" />
                    <x-text-input
                        id="password_confirmation"
                        class="block mt-1 w-full bg-gray-700 border border-gray-600 text-white rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                    />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400" />
                </div>

                <!-- Кнопка регистрации -->
                <div class="mt-6">
                    <button
                        type="submit"
                        class="w-full flex justify-center py-3 px-4 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-lg transition duration-300"
                    >
                        {{ __('Register') }}
                    </button>
                </div>

                <!-- Ссылка на вход -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-400">
                        {{ __('Already have an account?') }}
                        <a
                            href="{{ route('login') }}"
                            class="text-blue-400 hover:text-blue-300 underline"
                        >
                            {{ __('Log in') }}
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

</body>

</html>