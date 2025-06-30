@extends('admin.admin')

@section('title', __('Products Management'))

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <h1 class="text-2xl font-bold">{{ __('Products Management') }}</h1>
        
        <div class="flex items-center gap-4">
            <div class="relative">
                <input type="text" placeholder="{{ __('Search products...') }}" class="bg-gray-700/70 pl-10 pr-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/50 w-64">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
            
            <a href="{{ route('admin.products.create') }}" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg transition-all duration-300 flex items-center gap-2 shadow-lg hover:shadow-blue-500/30">
                <i class="fas fa-plus"></i>
                <span>{{ __('Add Product') }}</span>
            </a>
        </div>
    </div>
    
    <div class="bg-gray-800/60 backdrop-blur-sm rounded-xl border border-gray-700/50 shadow-lg overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-700/50 border-b border-gray-700">
                        <th class="py-4 px-6 text-left">
                            <div class="flex items-center space-x-1 text-xs uppercase tracking-wider font-semibold text-gray-400">
                                <span>{{ __('ID') }}</span>
                                <i class="fas fa-sort text-gray-600"></i>
                            </div>
                        </th>
                        <th class="py-4 px-6 text-left">
                            <div class="flex items-center space-x-1 text-xs uppercase tracking-wider font-semibold text-gray-400">
                                <span>{{ __('Image') }}</span>
                            </div>
                        </th>
                        <th class="py-4 px-6 text-left">
                            <div class="flex items-center space-x-1 text-xs uppercase tracking-wider font-semibold text-gray-400">
                                <span>{{ __('Name') }}</span>
                                <i class="fas fa-sort text-gray-600"></i>
                            </div>
                        </th>
                        <th class="py-4 px-6 text-left">
                            <div class="flex items-center space-x-1 text-xs uppercase tracking-wider font-semibold text-gray-400">
                                <span>{{ __('Category') }}</span>
                                <i class="fas fa-sort text-gray-600"></i>
                            </div>
                        </th>
                        <th class="py-4 px-6 text-left">
                            <div class="flex items-center space-x-1 text-xs uppercase tracking-wider font-semibold text-gray-400">
                                <span>{{ __('Price') }}</span>
                                <i class="fas fa-sort text-gray-600"></i>
                            </div>
                        </th>
                        <th class="py-4 px-6 text-left">
                            <div class="flex items-center space-x-1 text-xs uppercase tracking-wider font-semibold text-gray-400">
                                <span>{{ __('Status') }}</span>
                                <i class="fas fa-sort text-gray-600"></i>
                            </div>
                        </th>
                        <th class="py-4 px-6 text-center">
                            <div class="flex items-center justify-center space-x-1 text-xs uppercase tracking-wider font-semibold text-gray-400">
                                <span>{{ __('Actions') }}</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr class="border-b border-gray-700/50 hover:bg-gray-700/30 transition-all duration-200">
                        <td class="py-4 px-6 text-gray-300">{{ $product->id }}</td>
                        <td class="py-4 px-6">
                            <div class="w-12 h-12 bg-gray-700 rounded-lg overflow-hidden flex items-center justify-center">
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="max-w-full max-h-full object-contain">
                            </div>
                        </td>
                        <td class="py-4 px-6 font-medium">{{ $product->name }}</td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-500/20 text-blue-400">
                                {{ $product->category->name }}
                            </span>
                        </td>
                        <td class="py-4 px-6 font-medium">
                            @if($product->discount_price)
                                <span class="text-green-400">${{ $product->discount_price }}</span>
                                <span class="text-gray-400 line-through text-sm ml-1">${{ $product->price }}</span>
                            @else
                                <span>${{ $product->price }}</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/20 text-green-400">
                                <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5"></span>
                                {{ __('Active') }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center justify-center space-x-3">
                                <a href="{{ route('admin.products.edit', $product) }}" class="bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 p-2 rounded-lg transition-all duration-200" title="{{ __('Edit') }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="bg-amber-600/20 hover:bg-amber-600/40 text-amber-400 p-2 rounded-lg transition-all duration-200" title="{{ __('View') }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600/20 hover:bg-red-600/40 text-red-400 p-2 rounded-lg transition-all duration-200" title="{{ __('Delete') }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Пагинация -->
    <div class="flex justify-between items-center">
        <div class="text-sm text-gray-400">
            {{ __('Showing') }} <span class="font-medium">1</span> {{ __('to') }} <span class="font-medium">10</span> {{ __('of') }} <span class="font-medium">{{ $products->total() }}</span> {{ __('results') }}
        </div>
        
        <div class="mt-6 bg-gray-800/70 backdrop-blur-sm rounded-lg border border-gray-700/50 shadow-lg p-1">
            {{ $products->links() }}
        </div>
    </div>
@endsection