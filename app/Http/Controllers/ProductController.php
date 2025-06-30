<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Фильтры
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->has('brand')) {
            $query->where('brand', $request->brand);
        }
        if ($request->has('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->has('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'popular':
                    $query->orderBy('popularity', 'desc'); // Предполагается поле popularity
                    break;
            }
        }

        $products = $query->paginate(9);
        $categories = Category::all();
        $brands = Product::distinct()->pluck('brand');

        // Добавляем статус избранного для каждого товара
        if (Auth::check()) {
            $favoriteProductIds = Favorite::where('user_id', Auth::id())->pluck('product_id')->toArray();
            
            foreach ($products as $product) {
                $product->isFavorited = in_array($product->id, $favoriteProductIds);
            }
        }

        return view('products.index', compact('products', 'categories', 'brands'));
    }
}