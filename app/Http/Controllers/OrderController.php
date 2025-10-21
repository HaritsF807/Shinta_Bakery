<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Inertia\Inertia;

class OrderController extends Controller
{
    // Form checkout
    public function create()
    {
        $cart = session()->get('cart', []);

        return Inertia::render('Checkout/Create', [
            'cart' => $cart,
        ]);
    }

    // Simpan pesanan
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong!');
        }

        $validated = $request->validate([
            'guest_name' => 'nullable|string|max:255',
            'guest_email' => 'nullable|email|max:255',
            'guest_phone' => 'nullable|string|max:30',
            'shipping_address' => 'nullable|string|max:500',
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'guest_name' => $validated['guest_name'] ?? null,
            'guest_email' => $validated['guest_email'] ?? null,
            'guest_phone' => $validated['guest_phone'] ?? null,
            'shipping_address' => $validated['shipping_address'] ?? null,
            'total_price' => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
            'status' => 'pending',
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
                'status' => 'pending',
            ]);
        }

        session()->forget('cart'); // kosongkan keranjang

        return redirect()->route('checkout.success')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function success()
    {
        return Inertia::render('Checkout/Success');
    }
}
