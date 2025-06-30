<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $product = Product::findOrFail($productId);
        $cart = session('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'price' => Auth::check() && $product->discount_price ? $product->discount_price : $product->price,
                'quantity' => 1,
                'image' => $product->image,
            ];
        }

        session(['cart' => $cart]);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('Product added to cart'),
                'cart_count' => count($cart)
            ]);
        }
        
        return redirect()->route('cart.index')->with('success', __('Product added to cart'));
    }

    public function update(Request $request)
    {
        $cart = session('cart', []);
        $productId = $request->input('product_id');
        $quantity = max(1, intval($request->input('quantity'))); // Ensure quantity is at least 1

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            session(['cart' => $cart]);
            
            if ($request->ajax()) {
                // Calculate item total and cart total for AJAX response
                $itemTotal = $cart[$productId]['price'] * $quantity;
                $cartTotal = array_reduce($cart, function($carry, $item) {
                    return $carry + ($item['price'] * $item['quantity']);
                }, 0);
                
                return response()->json([
                    'success' => true,
                    'item_total' => number_format($itemTotal, 2),
                    'cart_total' => number_format($cartTotal, 2),
                ]);
            }
        }

        return redirect()->route('cart.index');
    }

    public function remove(Request $request)
    {
        $cart = session('cart', []);
        $productId = $request->input('product_id');

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session(['cart' => $cart]);
            
            if ($request->ajax()) {
                $cartTotal = array_reduce($cart, function($carry, $item) {
                    return $carry + ($item['price'] * $item['quantity']);
                }, 0);
                
                return response()->json([
                    'success' => true,
                    'cart_total' => number_format($cartTotal, 2),
                    'cart_count' => count($cart)
                ]);
            }
        }

        return redirect()->route('cart.index');
    }
}