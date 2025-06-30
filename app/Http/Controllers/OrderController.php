<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', __('Your cart is empty'));
        }
        return view('orders.checkout', compact('cart'));
    }

    public function store(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', __('Your cart is empty'));
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
        ]);

        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        Order::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'items' => $cart,
            'total' => $total,
            'status' => 'pending',
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        session()->forget('cart');
        return redirect()->route('home')->with('success', __('Order placed successfully'));
    }
}