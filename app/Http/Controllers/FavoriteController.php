<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to add favorites.');
        }

        $favorite = Favorite::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to favorites.',
            'isFavorited' => true,
        ]);
    }
    
    public function destroy(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to remove favorites.');
        }

        $favorite = Favorite::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json([
                'success' => true,
                'message' => 'Product removed from favorites.',
                'isFavorited' => false,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Favorite not found.',
            'isFavorited' => false,
        ]);
    }

    public function toggle(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please log in to manage favorites.',
                'isFavorited' => false,
            ], 401);
        }

        $favorite = Favorite::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json([
                'success' => true,
                'message' => 'Product removed from favorites.',
                'isFavorited' => false,
            ]);
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Product added to favorites.',
                'isFavorited' => true,
            ]);
        }
    }
}