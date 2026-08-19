<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Get cart contents
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('frontend.cart', compact('cart'));
    }

    // Add to cart
    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = (int) $request->input('quantity', 1);

        if ($quantity <= 0) {
            return response()->json(['success' => false, 'message' => 'Quantity must be at least 1.'], 400);
        }

        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
        }

        $cart = session()->get('cart', []);

        // Check stock availability
        if ($product->quantity <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, this product is currently out of stock.'
            ], 400);
        }

        $currentQty = isset($cart[$productId]) ? $cart[$productId]['quantity'] : 0;
        $newQty = $currentQty + $quantity;

        if ($newQty > $product->quantity) {
            $available = max(0, $product->quantity - $currentQty);
            if ($available <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'You already have the maximum available stock (' . $product->quantity . ') in your cart.'
                ], 400);
            }
            return response()->json([
                'success' => false,
                'message' => 'Cannot add ' . $quantity . ' items. Only ' . $available . ' more unit(s) available in stock.'
            ], 400);
        }

        // Prepare image
        $image = $product->primary_image_url;

        $price = $product->sale_price ?? $product->price;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $price,
                'image' => $image,
                'slug' => $product->slug
            ];
        }

        session()->put('cart', $cart);

        $totalCount = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cart_count' => $totalCount,
            'cart' => $cart
        ]);
    }

    // Update cart item quantity
    public function update(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = (int) $request->input('quantity');

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $product = Product::find($productId);
            if ($quantity > 0 && $product && $quantity > $product->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot update quantity. Only ' . $product->quantity . ' unit(s) available in stock for ' . $product->name . '.'
                ], 400);
            }

            if ($quantity <= 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['quantity'] = $quantity;
            }
            session()->put('cart', $cart);
        }

        $totalCount = array_sum(array_column($cart, 'quantity'));
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully!',
            'cart_count' => $totalCount,
            'total_price' => $totalPrice,
            'cart' => $cart
        ]);
    }

    // Remove from cart
    public function remove(Request $request)
    {
        $productId = $request->input('product_id');
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        $totalCount = array_sum(array_column($cart, 'quantity'));
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart successfully!',
            'cart_count' => $totalCount,
            'total_price' => $totalPrice,
            'cart' => $cart
        ]);
    }

    // Get cart item count
    public function count()
    {
        $cart = session()->get('cart', []);
        $totalCount = array_sum(array_column($cart, 'quantity'));
        return response()->json(['cart_count' => $totalCount]);
    }
}
