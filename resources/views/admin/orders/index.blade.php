@extends('admin.admin')

@section('title', __('Orders Management'))

@section('content')
    <div class="bg-gray-800/80 backdrop-blur-sm rounded-lg border border-gray-700/50 shadow-xl overflow-hidden">
        <div class="p-6 border-b border-gray-700/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-white">{{ __('Orders Management') }}</h1>
                <p class="text-gray-400 mt-1">{{ __('View and manage customer orders') }}</p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative">
                    <input type="text" placeholder="{{ __('Search orders...') }}" class="bg-gray-700/70 py-2 px-4 pr-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/50 w-full sm:w-64">
                    <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                </div>
                
                <div class="flex gap-2">
                    <select class="bg-gray-700/70 py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-gray-300">
                        <option value="">{{ __('Filter by status') }}</option>
                        <option value="pending">{{ __('Pending') }}</option>
                        <option value="processing">{{ __('Processing') }}</option>
                        <option value="completed">{{ __('Completed') }}</option>
                        <option value="cancelled">{{ __('Cancelled') }}</option>
                    </select>
                    
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                        <i class="fas fa-download mr-2"></i> {{ __('Export') }}
                    </button>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-gray-700/50 rounded-lg p-4 border border-gray-600/50">
                    <div class="flex items-center">
                        <div class="bg-blue-500/20 p-3 rounded-lg mr-4">
                            <i class="fas fa-shopping-bag text-blue-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">{{ __('Total Orders') }}</p>
                            <p class="text-2xl font-semibold">{{ $orders->total() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-700/50 rounded-lg p-4 border border-gray-600/50">
                    <div class="flex items-center">
                        <div class="bg-green-500/20 p-3 rounded-lg mr-4">
                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">{{ __('Completed') }}</p>
                            <p class="text-2xl font-semibold">{{ $orders->where('status', 'completed')->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-700/50 rounded-lg p-4 border border-gray-600/50">
                    <div class="flex items-center">
                        <div class="bg-yellow-500/20 p-3 rounded-lg mr-4">
                            <i class="fas fa-clock text-yellow-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">{{ __('Pending') }}</p>
                            <p class="text-2xl font-semibold">{{ $orders->where('status', 'pending')->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-700/50 rounded-lg p-4 border border-gray-600/50">
                    <div class="flex items-center">
                        <div class="bg-red-500/20 p-3 rounded-lg mr-4">
                            <i class="fas fa-times-circle text-red-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">{{ __('Cancelled') }}</p>
                            <p class="text-2xl font-semibold">{{ $orders->where('status', 'cancelled')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto rounded-lg">
                <table class="w-full bg-gray-800/90 rounded-lg">
                    <thead>
                        <tr class="bg-gray-700/50 text-gray-300">
                            <th class="py-3 px-4 text-left font-medium">
                                <div class="flex items-center">
                                    {{ __('Order ID') }}
                                    <button class="ml-1 text-gray-500 hover:text-gray-300">
                                        <i class="fas fa-sort"></i>
                                    </button>
                                </div>
                            </th>
                            <th class="py-3 px-4 text-left font-medium">
                                <div class="flex items-center">
                                    {{ __('Customer') }}
                                    <button class="ml-1 text-gray-500 hover:text-gray-300">
                                        <i class="fas fa-sort"></i>
                                    </button>
                                </div>
                            </th>
                            <th class="py-3 px-4 text-left font-medium">
                                <div class="flex items-center">
                                    {{ __('Total') }}
                                    <button class="ml-1 text-gray-500 hover:text-gray-300">
                                        <i class="fas fa-sort"></i>
                                    </button>
                                </div>
                            </th>
                            <th class="py-3 px-4 text-left font-medium">{{ __('Status') }}</th>
                            <th class="py-3 px-4 text-left font-medium">
                                <div class="flex items-center">
                                    {{ __('Date') }}
                                    <button class="ml-1 text-gray-500 hover:text-gray-300">
                                        <i class="fas fa-sort"></i>
                                    </button>
                                </div>
                            </th>
                            <th class="py-3 px-4 text-center font-medium">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="border-t border-gray-700/50 hover:bg-gray-700/30 transition-colors">
                                <td class="py-3 px-4">
                                    <span class="font-mono text-sm font-medium">#{{ $order->id }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center mr-3 text-xs uppercase">
                                            {{ substr($order->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-medium">{{ $order->name }}</p>
                                            <p class="text-gray-400 text-sm">{{ $order->email ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 font-medium">${{ number_format($order->total, 2) }}</td>
                                <td class="py-3 px-4">
                                    @if($order->status == 'completed')
                                        <span class="px-2 py-1 bg-green-500/20 text-green-400 rounded-full text-xs font-medium">
                                            {{ __('Completed') }}
                                        </span>
                                    @elseif($order->status == 'processing')
                                        <span class="px-2 py-1 bg-blue-500/20 text-blue-400 rounded-full text-xs font-medium">
                                            {{ __('Processing') }}
                                        </span>
                                    @elseif($order->status == 'pending')
                                        <span class="px-2 py-1 bg-yellow-500/20 text-yellow-400 rounded-full text-xs font-medium">
                                            {{ __('Pending') }}
                                        </span>
                                    @elseif($order->status == 'cancelled')
                                        <span class="px-2 py-1 bg-red-500/20 text-red-400 rounded-full text-xs font-medium">
                                            {{ __('Cancelled') }}
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-500/20 text-gray-400 rounded-full text-xs font-medium">
                                            {{ $order->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-gray-300">
                                    <div class="flex flex-col">
                                        <span>{{ $order->created_at->format('d.m.Y') }}</span>
                                        <span class="text-gray-400 text-sm">{{ $order->created_at->format('H:i') }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin.orders') }}/{{ $order->id }}" class="p-2 bg-blue-500/20 text-blue-400 rounded-lg hover:bg-blue-500/40 transition-colors">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.orders') }}/{{ $order->id }}/edit" class="p-2 bg-yellow-500/20 text-yellow-400 rounded-lg hover:bg-yellow-500/40 transition-colors">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button data-order-id="{{ $order->id }}" class="delete-btn p-2 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500/40 transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Пагинация -->
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
    
    <!-- Модальное окно подтверждения удаления -->
    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black/50 backdrop-blur-sm hidden">
        <div class="bg-gray-800 border border-gray-700 rounded-lg shadow-xl max-w-md w-full p-6">
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-500/20 text-red-500 mb-4">
                    <i class="fas fa-exclamation-triangle text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold">{{ __('Confirm Deletion') }}</h3>
                <p class="text-gray-400 mt-2">{{ __('Are you sure you want to delete this order? This action cannot be undone.') }}</p>
            </div>
            
            <div class="flex gap-3">
                <button id="cancelDelete" class="flex-1 py-2 px-4 bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors focus:outline-none">
                    {{ __('Cancel') }}
                </button>
                <form id="deleteForm" action="" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-2 px-4 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors focus:outline-none">
                        {{ __('Delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all delete buttons
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const deleteModal = document.getElementById('deleteModal');
            const deleteForm = document.getElementById('deleteForm');
            const cancelDelete = document.getElementById('cancelDelete');
            
            // Add click event to each delete button
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const orderId = this.getAttribute('data-order-id');
                    deleteForm.action = `/admin/orders/${orderId}`;
                    deleteModal.classList.remove('hidden');
                });
            });
            
            // Cancel delete
            cancelDelete.addEventListener('click', function() {
                deleteModal.classList.add('hidden');
            });
            
            // Close modal when clicking outside
            deleteModal.addEventListener('click', function(e) {
                if (e.target === deleteModal) {
                    deleteModal.classList.add('hidden');
                }
            });
        });
    </script>
@endsection