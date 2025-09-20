<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Get cart items with product details
        $cartItems = [];
        $total = 0;

        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();

        foreach ($products as $product) {
            $quantity = $cart[$product->id];
            $subtotal = $product->price * $quantity;
            
            $cartItems[] = [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $subtotal
            ];
            
            $total += $subtotal;
        }

        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:10|regex:/^[a-zA-Z\s]+$/',
            'phone' => 'required|digits:11',
            'address' => 'required|string'
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Get cart items with product details for storage
        $cartItems = [];
        $total = 0;

        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();

        foreach ($products as $product) {
            $quantity = $cart[$product->id];
            $subtotal = $product->price * $quantity;
            
            $cartItems[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'subtotal' => $subtotal
            ];
            
            $total += $subtotal;
        }

        // Create order
        $order = Order::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'cart_items' => $cartItems,
            'total_amount' => $total
        ]);

        // Clear cart
        session()->forget('cart');

        return redirect()->route('checkout.success', $order->id);
    }

    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('checkout.success', compact('order'));
    }
}