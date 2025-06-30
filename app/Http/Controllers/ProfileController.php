<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
            $favorites = Favorite::where('user_id', Auth::id())->with('product')->get();
            return view('profile.index', compact('orders', 'favorites'));
        }
        
        return redirect()->route('login');
    }

    public function removeFavorite(Request $request)
    {
        if (Auth::check()) {
            $favorite = Favorite::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->first();
                
            if ($favorite) {
                $favorite->delete();
                return redirect()->back()->with('success', __('Removed from favorites'));
            }
            
            return redirect()->back()->with('error', __('Favorite not found'));
        }
        
        return redirect()->route('login');
    }
}