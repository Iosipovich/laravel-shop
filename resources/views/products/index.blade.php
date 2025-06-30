<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Products') }} - Tech Shop</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js"></script>
    <style>
        .noUi-connect {
            background: rgb(96 165 250);
        }
    </style>
    @php
    use App\Models\Favorite;
    @endphp
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
                        <span class="ml-2 bg-blue-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
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

    <!-- Основной контент -->
    <section class="py-8 md:py-12 bg-gradient-to-br from-gray-900 to-gray-800 text-white min-h-screen">
        <div class="container mx-auto px-4">
            <!-- Мобильный фильтр переключатель -->
            <div class="block md:hidden mb-6">
                <button id="filterToggle" class="w-full flex items-center justify-between bg-blue-600 text-white p-4 rounded-lg hover:bg-blue-500 transition shadow-md">
                    <span class="font-medium">{{ __('Filters') }}</span>
                    <i class="fas fa-sliders-h"></i>
                </button>
            </div>

            <div class="flex flex-col md:flex-row gap-6">
                <!-- Фильтры -->
                <aside id="filterPanel" class="w-full md:w-1/4 bg-gray-800 p-5 rounded-xl shadow-xl border h-full border-gray-700 hidden md:block transition-all duration-300 mb-6 md:mb-0">
                    <div class="flex justify-between items-center mb-5 border-b border-gray-700 pb-3">
                        <h2 class="text-2xl font-bold">{{ __('Filters') }}</h2>
                        <button id="clearFilters" class="text-sm text-blue-400 hover:text-blue-300 transition">
                            <i class="fas fa-times-circle mr-1"></i>{{ __('Clear all') }}
                        </button>
                    </div>

                    <form id="filterForm" method="GET" action="/products" class="space-y-6">
                        <!-- Категории -->
                        <div class="filter-group">
                            <h3 class="text-lg font-semibold mb-3 flex items-center">
                                <i class="fas fa-tags text-blue-500 mr-2"></i>{{ __('Categories') }}
                            </h3>
                            <div class="space-y-2 pl-1">
                                @foreach ($categories as $category)
                                <label class="flex items-center gap-2 text-gray-300 hover:text-white transition cursor-pointer">
                                    <input type="checkbox" name="category" value="{{ $category->id }}"
                                        {{ request('category') == $category->id ? 'checked' : '' }}
                                        class="filter-checkbox accent-blue-500 category-checkbox">
                                    <span>{{ $category->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Бренды -->
                        <div class="filter-group">
                            <h3 class="text-lg font-semibold mb-3 flex items-center">
                                <i class="fas fa-building text-blue-500 mr-2"></i>{{ __('Brands') }}
                            </h3>
                            <div class="space-y-2 pl-1">
                                @foreach ($brands as $brand)
                                <label class="flex items-center gap-2 text-gray-300 hover:text-white transition cursor-pointer">
                                    <input type="checkbox" name="brand" value="{{ $brand }}"
                                        {{ request('brand') == $brand ? 'checked' : '' }}
                                        class="filter-checkbox accent-blue-500 brand-checkbox">
                                    <span>{{ $brand }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Цена - двойной ползунок -->
                        <div class="filter-group">
                            <h3 class="text-lg font-semibold mb-3 flex items-center">
                                <i class="fas fa-dollar-sign text-blue-500 mr-2"></i>{{ __('Price Range') }}
                            </h3>

                            <div class="mb-4">
                                <div id="price-slider" class="h-2 bg-gray-700 rounded-lg relative mt-6 mb-4"></div>

                                <div class="flex justify-between items-center mt-2">
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">$</span>
                                        <input type="number" id="price_min" name="price_min" value="{{ request('price_min', 0) }}"
                                            class="w-24 p-2 pl-8 bg-gray-700 rounded-lg text-white border border-gray-600 focus:border-blue-500 focus:outline-none transition">
                                    </div>
                                    <span class="text-gray-500">—</span>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">$</span>
                                        <input type="number" id="price_max" name="price_max" value="{{ request('price_max', 2000) }}"
                                            class="w-24 p-2 pl-8 bg-gray-700 rounded-lg text-white border border-gray-600 focus:border-blue-500 focus:outline-none transition">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Сортировка -->
                        <div class="filter-group">
                            <h3 class="text-lg font-semibold mb-3 flex items-center">
                                <i class="fas fa-sort text-blue-500 mr-2"></i>{{ __('Sort By') }}
                            </h3>
                            <select name="sort" id="sort-select" class="w-full p-3 bg-gray-700 rounded-lg text-white border border-gray-600 focus:border-blue-500 focus:outline-none transition">
                                <option value="">{{ __('Default') }}</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>{{ __('Price: Low to High') }}</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>{{ __('Price: High to Low') }}</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ __('Newest First') }}</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>{{ __('Most Popular') }}</option>
                            </select>
                        </div>
                    </form>
                </aside>

                <!-- Товары -->
                <div class="w-full md:w-3/4">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-700">
                        <h1 class="text-2xl md:text-3xl font-bold">{{ __('Products') }}</h1>
                        <div class="flex items-center gap-3">
                            <span class="text-gray-400 text-sm hidden sm:inline">{{ $products->total() }} {{ __('items') }}</span>
                            <div class="flex border border-gray-700 rounded-lg overflow-hidden">
                                <button class="grid-view-btn bg-gray-800 px-3 py-2 text-blue-500 hover:bg-gray-700 transition">
                                    <i class="fas fa-th"></i>
                                </button>
                                <button class="list-view-btn bg-gray-800 px-3 py-2 text-gray-400 hover:bg-gray-700 transition">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6" id="product-grid">
                        @forelse ($products as $product)
                        <div class="bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition group overflow-hidden border border-gray-700 hover:border-gray-600">
                            <div class="relative">
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-56 object-contain bg-gray-900 p-4">
                                @auth
                                <form action="{{ route('favorites.toggle') }}" method="POST" class="favorite-form absolute top-3 right-3">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="favorite-btn bg-gray-700 hover:bg-gray-600 transition text-xl w-10 h-10 flex items-center justify-center rounded-full shadow-md">
                                        <i class="{{ $product->isFavorited ? 'fas text-red-500' : 'far text-white' }} fa-heart"></i>
                                    </button>
                                </form>
                                @endauth
                                @if(isset($product->discount_price) && $product->discount_price < $product->price)
                                    <div class="absolute top-3 left-3 bg-red-600 text-white px-3 py-1 rounded-full text-xs font-bold">
                                        -{{ round((1 - $product->discount_price / $product->price) * 100) }}%
                                    </div>
                                    @endif
                            </div>
                            <div class="p-5">
                                <h3 class="text-xl font-bold mb-2 truncate">{{ $product->name }}</h3>
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="flex items-center text-yellow-500">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <span class="ml-1 text-gray-400 text-sm">(4.5)</span>
                                    </div>
                                </div>
                                <p class="text-lg font-bold mb-4">
                                    @auth
                                    @if(isset($product->discount_price) && $product->discount_price < $product->price)
                                        <span class="line-through text-gray-500 text-sm mr-2">${{ $product->price }}</span>
                                        <span class="text-white">${{ $product->discount_price }}</span>
                                        @else
                                        <span class="text-white">${{ $product->price }}</span>
                                        @endif
                                        @else
                                        <span class="text-white">${{ $product->price }}</span>
                                        @endauth
                                </p>
                                <div class="flex justify-between items-center gap-2">
                                    <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition flex items-center justify-center gap-2">
                                            <i class="fas fa-shopping-cart"></i>
                                            <span>{{ __('Add to Cart') }}</span>
                                        </button>
                                    </form>
                                    <a href="/products/{{ $product->id }}" class="bg-gray-700 hover:bg-gray-600 transition p-2 rounded-lg">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full py-12 text-center">
                            <i class="fas fa-search text-5xl text-gray-600 mb-4"></i>
                            <p class="text-xl text-gray-400">{{ __('No products found') }}</p>
                            <button id="clearFiltersEmpty" class="mt-4 text-blue-500 hover:text-blue-400 transition">
                                {{ __('Clear all filters and try again') }}
                            </button>
                        </div>
                        @endforelse
                    </div>

                    <!-- Пагинация -->
                    <div class="mt-10 flex justify-center">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Инициализация и настройка двустороннего ползунка цены
            const priceSlider = document.getElementById('price-slider');
            const minPriceInput = document.getElementById('price_min');
            const maxPriceInput = document.getElementById('price_max');

            // Получение минимальной и максимальной цены из инпутов
            let minPrice = parseInt(minPriceInput.value) || 0;
            let maxPrice = parseInt(maxPriceInput.value) || 2000;

            if (priceSlider) {
                noUiSlider.create(priceSlider, {
                    start: [minPrice, maxPrice],
                    connect: true,
                    step: 1,
                    range: {
                        'min': 0,
                        'max': 2000
                    },
                    format: {
                        to: function(value) {
                            return Math.round(value);
                        },
                        from: function(value) {
                            return Number(value);
                        }
                    }
                });

                // Обновление инпутов при изменении ползунка
                priceSlider.noUiSlider.on('update', function(values, handle) {
                    if (handle === 0) {
                        minPriceInput.value = values[0];
                    } else {
                        maxPriceInput.value = values[1];
                    }
                });

                // Обновление ползунка при изменении инпутов
                minPriceInput.addEventListener('change', function() {
                    priceSlider.noUiSlider.set([this.value, null]);
                    submitForm();
                });

                maxPriceInput.addEventListener('change', function() {
                    priceSlider.noUiSlider.set([null, this.value]);
                    submitForm();
                });

                // Автообновление страницы при изменении цены через ползунок
                priceSlider.noUiSlider.on('change', function() {
                    submitForm();
                });
            }

            // Обработка изменения чекбоксов категорий и брендов
            const filterCheckboxes = document.querySelectorAll('.filter-checkbox');
            filterCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // Проверяем, есть ли другие чекбоксы той же группы, которые отмечены
                    const checkboxName = this.name;
                    const checkboxValue = this.value;

                    // Получаем все чекбоксы той же группы
                    const groupCheckboxes = document.querySelectorAll(`input[name="${checkboxName}"]`);

                    // Проверяем и снимаем отметку с других чекбоксов этой группы
                    groupCheckboxes.forEach(cb => {
                        if (cb !== this && cb.checked) {
                            cb.checked = false;
                        }
                    });

                    submitForm();
                });
            });

            // Сортировка
            document.getElementById('sort-select').addEventListener('change', function() {
                submitForm();
            });

            // Функция для отправки формы
            function submitForm() {
                // Собираем данные для запроса
                const form = document.getElementById('filterForm');
                const formData = new FormData(form);
                const params = new URLSearchParams();

                // Добавляем только выбранные параметры
                for (const [key, value] of formData.entries()) {
                    if (value) {
                        params.append(key, value);
                    }
                }

                // Отправляем запрос
                window.location.href = '/products?' + params.toString();
            }

            // Очистка всех фильтров
            document.getElementById('clearFilters')?.addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = '/products';
            });

            // Мобильный переключатель фильтров
            document.getElementById('filterToggle')?.addEventListener('click', function() {
                const filterPanel = document.getElementById('filterPanel');
                if (filterPanel) {
                    filterPanel.classList.toggle('hidden');
                }
            });

            document.getElementById('clearFiltersEmpty')?.addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = '/products';
            });

            // Переключение вида товаров (сетка/список)
            const productGrid = document.querySelector('.grid');

            document.querySelector('.grid-view-btn')?.addEventListener('click', function() {
                this.classList.replace('text-gray-400', 'text-blue-500');
                document.querySelector('.list-view-btn').classList.replace('text-blue-500', 'text-gray-400');

                if (productGrid) {
                    productGrid.classList.remove('grid-cols-1');
                    productGrid.classList.add('grid-cols-1', 'sm:grid-cols-2', 'lg:grid-cols-3');
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
        });
    </script>

    @include('layouts.chat')
</body>

</html>