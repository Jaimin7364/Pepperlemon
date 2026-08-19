<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class WishlistController extends Controller
{
    // Toggle product in wishlist
    public function toggle(Request $request)
    {
        $productId = $request->input('product_id');
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
        }

        $wishlist = session()->get('wishlist', []);

        if (in_array($productId, $wishlist)) {
            // Remove it
            $wishlist = array_values(array_diff($wishlist, [$productId]));
            $inWishlist = false;
            $message = 'Product removed from wishlist.';
        } else {
            // Add it
            $wishlist[] = $productId;
            $inWishlist = true;
            $message = 'Product added to wishlist successfully!';
        }

        session()->put('wishlist', $wishlist);

        return response()->json([
            'success' => true,
            'message' => $message,
            'in_wishlist' => $inWishlist,
            'wishlist_count' => count($wishlist)
        ]);
    }

    // Get wishlist items count
    public function count()
    {
        $wishlist = session()->get('wishlist', []);
        return response()->json(['wishlist_count' => count($wishlist)]);
    }

    // View wishlist page
    public function index()
    {
        $wishlistIds = session()->get('wishlist', []);
        $products = Product::whereIn('id', $wishlistIds)->where('is_active', true)->get();
        return view('frontend.wishlist', compact('products'));
    }
}
