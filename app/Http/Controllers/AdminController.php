<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
{
    $productsCount = Product::count();
    $ordersCount = Order::count();
    $pendingOrders = Order::where('status', 'pending')->count();
    return view('admin.dashboard', compact('productsCount', 'ordersCount', 'pendingOrders'));
}

public function products()
{
    $products = Product::with('category')->paginate(10);
    return view('admin.products.index', compact('products'));
}

    public function createProduct()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
{
    // Преобразуем JSON-строку в массив
    $specs = json_decode($request->input('specs'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'specs' => ['The specs field must be a valid JSON string'],
        ]);
    }

    $request->merge(['specs' => $specs]); // Заменяем строку на массив в запросе

    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'discount_price' => 'nullable|numeric|min:0',
        'brand' => 'required|string|max:255',
        'specs' => 'required|array',
        'image' => 'required|url',
        'category_id' => 'required|exists:categories,id',
    ]);

    Product::create($request->all());
    return redirect()->route('admin.products')->with('success', __('Product created'));
}

    public function editProduct(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, Product $product)
{
    // Преобразуем JSON-строку в массив
    $specs = json_decode($request->input('specs'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'specs' => ['The specs field must be a valid JSON string'],
        ]);
    }

    $request->merge(['specs' => $specs]); // Заменяем строку на массив в запросе

    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'discount_price' => 'nullable|numeric|min:0',
        'brand' => 'required|string|max:255',
        'specs' => 'required|array',
        'image' => 'required|url',
        'category_id' => 'required|exists:categories,id',
    ]);

    $product->update($request->all());
    return redirect()->route('admin.products')->with('success', __('Product updated'));
}

    public function destroyProduct(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products')->with('success', __('Product deleted'));
    }

    public function orders()
    {
        $orders = Order::paginate(10);
        return view('admin.orders.index', compact('orders'));
    }
}