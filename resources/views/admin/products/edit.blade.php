@extends('admin.admin')

@section('title', __('Edit Product'))

@section('content')
<div class="bg-gray-800/80 backdrop-blur-sm border border-gray-700/50 rounded-xl shadow-xl overflow-hidden">
    <div class="bg-gradient-to-r from-indigo-600/80 to-purple-600/80 p-6">
        <h1 class="text-3xl font-bold flex items-center">
            <i class="fas fa-edit mr-3"></i>
            {{ __('Edit Product') }}
        </h1>
        <p class="text-indigo-100 mt-2">{{ __('Editing') }}: {{ $product->name }}</p>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Product Information Section -->
            <div class="space-y-6">
                <div class="bg-gray-750/50 p-4 rounded-lg border border-gray-700/50">
                    <h2 class="text-xl font-semibold mb-4 flex items-center text-indigo-400">
                        <i class="fas fa-info-circle mr-2"></i>
                        {{ __('Basic Information') }}
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-gray-300 mb-1 font-medium">
                                {{ __('Product Name') }} <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <i class="fas fa-tag"></i>
                                </span>
                                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" 
                                    class="w-full pl-10 pr-3 py-2 bg-gray-700/70 border border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-500/30 rounded-lg transition-all duration-200 text-white" 
                                    placeholder="{{ __('Enter product name') }}" required>
                            </div>
                            @error('name')
                                <p class="text-red-400 mt-1 text-sm flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="brand" class="block text-gray-300 mb-1 font-medium">
                                {{ __('Brand') }} <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <i class="fas fa-building"></i>
                                </span>
                                <input type="text" name="brand" id="brand" value="{{ old('brand', $product->brand) }}" 
                                    class="w-full pl-10 pr-3 py-2 bg-gray-700/70 border border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-500/30 rounded-lg transition-all duration-200 text-white" 
                                    placeholder="{{ __('Enter brand name') }}" required>
                            </div>
                            @error('brand')
                                <p class="text-red-400 mt-1 text-sm flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="category_id" class="block text-gray-300 mb-1 font-medium">
                                {{ __('Category') }} <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <i class="fas fa-folder"></i>
                                </span>
                                <select name="category_id" id="category_id" 
                                    class="w-full pl-10 pr-3 py-2 bg-gray-700/70 border border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-500/30 rounded-lg transition-all duration-200 text-white appearance-none" 
                                    required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            </div>
                            @error('category_id')
                                <p class="text-red-400 mt-1 text-sm flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-750/50 p-4 rounded-lg border border-gray-700/50">
                    <h2 class="text-xl font-semibold mb-4 flex items-center text-indigo-400">
                        <i class="fas fa-dollar-sign mr-2"></i>
                        {{ __('Pricing') }}
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="price" class="block text-gray-300 mb-1 font-medium">
                                {{ __('Regular Price') }} <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <i class="fas fa-tag"></i>
                                </span>
                                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" 
                                    class="w-full pl-10 pr-3 py-2 bg-gray-700/70 border border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-500/30 rounded-lg transition-all duration-200 text-white" 
                                    placeholder="0.00" required>
                            </div>
                            @error('price')
                                <p class="text-red-400 mt-1 text-sm flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="discount_price" class="block text-gray-300 mb-1 font-medium">
                                {{ __('Discount Price') }}
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <i class="fas fa-percentage"></i>
                                </span>
                                <input type="number" name="discount_price" id="discount_price" value="{{ old('discount_price', $product->discount_price) }}" step="0.01" min="0" 
                                    class="w-full pl-10 pr-3 py-2 bg-gray-700/70 border border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-500/30 rounded-lg transition-all duration-200 text-white" 
                                    placeholder="0.00">
                            </div>
                            @error('discount_price')
                                <p class="text-red-400 mt-1 text-sm flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-gray-700/50">
                        <div class="flex items-center">
                            <input type="checkbox" name="on_sale" id="on_sale" class="rounded bg-gray-700 border-gray-600 text-indigo-500 focus:ring-indigo-500/30"
                                   {{ $product->discount_price ? 'checked' : '' }}>
                            <label for="on_sale" class="ml-2 text-gray-300">{{ __('Mark as on sale') }}</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Product Details Section -->
            <div class="space-y-6">
                <div class="bg-gray-750/50 p-4 rounded-lg border border-gray-700/50">
                    <h2 class="text-xl font-semibold mb-4 flex items-center text-indigo-400">
                        <i class="fas fa-file-alt mr-2"></i>
                        {{ __('Description & Details') }}
                    </h2>
                    
                    <div>
                        <label for="description" class="block text-gray-300 mb-1 font-medium">
                            {{ __('Description') }} <span class="text-red-400">*</span>
                        </label>
                        <textarea name="description" id="description" rows="5" 
                            class="w-full p-3 bg-gray-700/70 border border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-500/30 rounded-lg transition-all duration-200 text-white" 
                            placeholder="{{ __('Enter product description') }}" required>{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="text-red-400 mt-1 text-sm flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <div class="mt-4">
                        <label for="specs" class="block text-gray-300 mb-1 font-medium">
                            {{ __('Specifications') }} <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute top-2 right-2 bg-gray-800/80 backdrop-blur-sm rounded-lg p-1 text-xs text-gray-400 flex items-center">
                                <i class="fas fa-info-circle mr-1"></i>
                                {{ __('JSON Format') }}
                            </div>
                            <textarea name="specs" id="specs" rows="4" 
                                class="w-full p-3 bg-gray-700/70 border border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-500/30 rounded-lg transition-all duration-200 text-white font-mono text-sm" 
                                required>{{ old('specs', json_encode($product->specs, JSON_PRETTY_PRINT)) }}</textarea>
                        </div>
                        <div class="text-xs text-gray-400 mt-1">
                            <i class="fas fa-lightbulb mr-1 text-yellow-400"></i>
                            {{ __('Tip: Use key-value pairs in JSON format to define product specifications') }}
                        </div>
                        @error('specs')
                            <p class="text-red-400 mt-1 text-sm flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
                
                <div class="bg-gray-750/50 p-4 rounded-lg border border-gray-700/50">
                    <h2 class="text-xl font-semibold mb-4 flex items-center text-indigo-400">
                        <i class="fas fa-image mr-2"></i>
                        {{ __('Product Image') }}
                    </h2>
                    
                    <div class="space-y-4">
                        <!-- Current Image Preview -->
                        <div class="bg-gray-700/40 p-3 rounded-lg border border-gray-700/80">
                            <p class="text-sm text-gray-400 mb-2">{{ __('Current Image') }}:</p>
                            <div class="flex items-center">
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="h-16 w-16 object-cover rounded-md bg-gray-800">
                                <div class="ml-3">
                                    <p class="text-sm text-gray-300 truncate max-w-xs">{{ basename($product->image) }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-gray-300 mb-1 font-medium">
                                {{ __('Upload New Image') }}
                            </label>
                            <div class="border-2 border-dashed border-gray-600 rounded-lg p-4 text-center hover:border-indigo-500 transition-all duration-200">
                                <input type="file" name="image_file" id="image_file" accept="image/*" class="hidden"
                                       onchange="document.getElementById('image_preview').src = window.URL.createObjectURL(this.files[0]); document.getElementById('image_preview_container').classList.remove('hidden'); document.getElementById('drop_zone').classList.add('hidden');">
                                <label for="image_file" id="drop_zone" class="cursor-pointer block p-6">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-gray-300">{{ __('Drag & drop a new image or click to browse') }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ __('JPG, PNG or GIF, Max 5MB') }}</p>
                                </label>
                                <div id="image_preview_container" class="hidden">
                                    <img id="image_preview" class="mx-auto max-h-32 rounded" alt="{{ __('Preview') }}">
                                    <button type="button" class="mt-2 text-sm text-red-400 hover:text-red-300" 
                                            onclick="document.getElementById('image_file').value = ''; document.getElementById('image_preview_container').classList.add('hidden'); document.getElementById('drop_zone').classList.remove('hidden');">
                                        <i class="fas fa-trash-alt mr-1"></i>{{ __('Remove') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="--- or ---">
                            <div class="flex items-center my-3">
                                <div class="flex-grow border-t border-gray-700"></div>
                                <span class="flex-shrink px-3 text-gray-500 text-sm">{{ __('OR') }}</span>
                                <div class="flex-grow border-t border-gray-700"></div>
                            </div>
                        </div>
                        
                        <div>
                            <label for="image" class="block text-gray-300 mb-1 font-medium">
                                {{ __('Image URL') }}
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <i class="fas fa-link"></i>
                                </span>
                                <input type="url" name="image" id="image" value="{{ old('image', $product->image) }}" 
                                    class="w-full pl-10 pr-3 py-2 bg-gray-700/70 border border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-500/30 rounded-lg transition-all duration-200 text-white" 
                                    placeholder="{{ __('https://example.com/image.jpg') }}">
                            </div>
                            <div class="text-xs text-gray-400 mt-1">
                                <i class="fas fa-info-circle mr-1"></i>
                                {{ __('Enter a new URL or keep the current one') }}
                            </div>
                            @error('image')
                                <p class="text-red-400 mt-1 text-sm flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Additional fields section -->
        <div class="bg-gray-750/50 p-4 rounded-lg border border-gray-700/50 mt-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center text-indigo-400">
                <i class="fas fa-cogs mr-2"></i>
                {{ __('Additional Options') }}
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="stock" class="block text-gray-300 mb-1 font-medium">
                        {{ __('Stock Quantity') }}
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fas fa-boxes"></i>
                        </span>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock ?? 1) }}" min="0" 
                            class="w-full pl-10 pr-3 py-2 bg-gray-700/70 border border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-500/30 rounded-lg transition-all duration-200 text-white">
                    </div>
                </div>
                
                <div>
                    <label for="sku" class="block text-gray-300 mb-1 font-medium">
                        {{ __('SKU') }}
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fas fa-barcode"></i>
                        </span>
                        <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku ?? '') }}" 
                            class="w-full pl-10 pr-3 py-2 bg-gray-700/70 border border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-500/30 rounded-lg transition-all duration-200 text-white" 
                            placeholder="{{ __('Product SKU') }}">
                    </div>
                </div>
                
                <div>
                    <label for="weight" class="block text-gray-300 mb-1 font-medium">
                        {{ __('Weight (kg)') }}
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fas fa-weight"></i>
                        </span>
                        <input type="number" name="weight" id="weight" value="{{ old('weight', $product->weight ?? '') }}" step="0.01" min="0" 
                            class="w-full pl-10 pr-3 py-2 bg-gray-700/70 border border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-500/30 rounded-lg transition-all duration-200 text-white" 
                            placeholder="0.00">
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div class="flex items-center">
                    <input type="checkbox" name="featured" id="featured" class="rounded bg-gray-700 border-gray-600 text-indigo-500 focus:ring-indigo-500/30"
                           {{ $product->featured ?? false ? 'checked' : '' }}>
                    <label for="featured" class="ml-2 text-gray-300">{{ __('Mark as featured product') }}</label>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="published" id="published" class="rounded bg-gray-700 border-gray-600 text-indigo-500 focus:ring-indigo-500/30"
                           {{ $product->published ?? true ? 'checked' : '' }}>
                    <label for="published" class="ml-2 text-gray-300">{{ __('Product is published') }}</label>
                </div>
            </div>
        </div>
        
        <!-- Product history and metadata -->
        <div class="bg-gray-800/60 p-4 rounded-lg border border-gray-700/30">
            <div class="flex flex-wrap items-center justify-between text-xs text-gray-500">
                <div class="flex items-center mr-4 mb-2">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    {{ __('Created') }}: <span class="ml-1">{{ $product->created_at->format('M d, Y') }}</span>
                </div>
                <div class="flex items-center mr-4 mb-2">
                    <i class="fas fa-clock mr-1"></i>
                    {{ __('Last Updated') }}: <span class="ml-1">{{ $product->updated_at->format('M d, Y') }}</span>
                </div>
                <div class="flex items-center mr-4 mb-2">
                    <i class="fas fa-eye mr-1"></i>
                    {{ __('Views') }}: <span class="ml-1">{{ $product->views ?? 0 }}</span>
                </div>
                <div class="flex items-center mb-2">
                    <i class="fas fa-shopping-cart mr-1"></i>
                    {{ __('Orders') }}: <span class="ml-1">{{ $product->orders_count ?? 0 }}</span>
                </div>
            </div>
        </div>
        
        <!-- Action buttons -->
        <div class="flex flex-col sm:flex-row gap-3 justify-between mt-6">
            <div class="order-3 sm:order-1">
                <button type="button" class="px-5 py-3 bg-red-600/80 hover:bg-red-500/80 rounded-lg text-white flex items-center justify-center shadow-lg transition-all duration-200"
                        onclick="document.getElementById('deleteModal').classList.remove('hidden')">
                    <i class="fas fa-trash mr-2"></i>
                    {{ __('Delete Product') }}
                </button>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3 order-1 sm:order-2">
                <a href="{{ route('admin.products') }}" class="px-5 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg text-gray-300 hover:text-white transition-all duration-200 text-center flex items-center justify-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="px-5 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 rounded-lg text-white font-medium transition-all duration-200 shadow-lg flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i>
                    {{ __('Update Product') }}
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Delete confirmation modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50">
    <div class="bg-gray-800 rounded-xl shadow-2xl max-w-md w-full mx-4 overflow-hidden border border-gray-700/50">
        <div class="bg-red-600/90 p-4">
            <h3 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                {{ __('Delete Product') }}
            </h3>
        </div>
        
        <div class="p-6">
            <p class="text-gray-300 mb-6">
                {{ __('Are you sure you want to delete this product? This action cannot be undone and all associated data will be permanently removed.') }}
            </p>
            
            <div class="bg-gray-700/50 p-3 rounded-lg mb-6 flex items-center">
                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="h-12 w-12 object-cover rounded bg-gray-800">
                <div class="ml-3">
                    <p class="font-medium">{{ $product->name }}</p>
                    <p class="text-sm text-gray-400">{{ $product->brand }}</p>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <button type="button" class="sm:flex-1 order-2 sm:order-1 px-5 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg text-gray-300 hover:text-white flex items-center justify-center transition-all duration-200"
                        onclick="document.getElementById('deleteModal').classList.add('hidden')">
                    <i class="fas fa-times mr-2"></i>
                    {{ __('Cancel') }}
                </button>
                
                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="sm:flex-1 order-1 sm:order-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-5 py-3 bg-red-600 hover:bg-red-500 rounded-lg text-white font-medium flex items-center justify-center transition-all duration-200">
                        <i class="fas fa-trash-alt mr-2"></i>
                        {{ __('Delete Permanently') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle drag and drop functionality for image upload
        const dropZone = document.getElementById('drop_zone');
        const fileInput = document.getElementById('image_file');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            dropZone.classList.add('border-indigo-500', 'bg-indigo-500/10');
        }
        
        function unhighlight() {
            dropZone.classList.remove('border-indigo-500', 'bg-indigo-500/10');
        }
        
        dropZone.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            
            if (files.length) {
                document.getElementById('image_preview').src = window.URL.createObjectURL(files[0]);
                document.getElementById('image_preview_container').classList.remove('hidden');
                document.getElementById('drop_zone').classList.add('hidden');
            }
        }
        
        // Format JSON in specs textarea
        const specsTextarea = document.getElementById('specs');
        try {
            const formattedJSON = JSON.stringify(JSON.parse(specsTextarea.value), null, 2);
            specsTextarea.value = formattedJSON;
        } catch (e) {
            // If not valid JSON, leave as is
        }
        
        // Toggle sale price input based on checkbox
        const onSaleCheckbox = document.getElementById('on_sale');
        const discountPriceInput = document.getElementById('discount_price');
        
        function updateDiscountPriceState() {
            if (onSaleCheckbox.checked) {
                discountPriceInput.setAttribute('required', 'required');
                discountPriceInput.parentElement.parentElement.classList.add('border-l-4', 'border-l-indigo-500', 'pl-3');
            } else {
                discountPriceInput.removeAttribute('required');
                discountPriceInput.parentElement.parentElement.classList.remove('border-l-4', 'border-l-indigo-500', 'pl-3');
            }
        }
        
        // Initialize on page load
        updateDiscountPriceState();
        
        // Update when checkbox changes
        onSaleCheckbox.addEventListener('change', updateDiscountPriceState);
    });
</script>
@endsection