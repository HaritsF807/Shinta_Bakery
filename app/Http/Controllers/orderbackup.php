<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // 🧾 Halaman form checkout
    public function create()
    {
        $cart = session()->get('cart', []);

        return Inertia::render('Checkout/Create', [
            'cart' => $cart,
        ]);
    }

    // 💾 Simpan pesanan (guest atau login)
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong!');
        }

        $validated = $request->validate([
            'guest_name' => 'nullable|string|max:255',
            'guest_email' => 'nullable|email|max:255',
            'guest_phone' => 'required|string|max:30',
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|in:cod,transfer',
        ]);

        // 🔢 Hitung jumlah pesanan hari ini
        $today = now()->format('Y-m-d');
        $orderCountToday = Order::whereDate('created_at', $today)->count() + 1;

        // 🧾 Generate kode invoice, misal: INV-2110202501
        $invoiceNumber = 'INV-' . now()->format('dmY') . str_pad($orderCountToday, 2, '0', STR_PAD_LEFT);

        // 🧍 Buat order baru
        $order = Order::create([
            'invoice_number' => $invoiceNumber,
            'user_id' => Auth::id(),
            'guest_name' => $validated['guest_name'] ?? null,
            'guest_email' => $validated['guest_email'] ?? null,
            'guest_phone' => $validated['guest_phone'] ?? null,
            'shipping_address' => $validated['shipping_address'] ?? null,
            'payment_method' => $validated['payment_method'],
            'total_price' => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
            'status' => 'pending',
        ]);

        // 💽 Simpan item pesanan
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

        // 🧹 Kosongkan keranjang
        session()->forget('cart');

        // 🚀 Arahkan ke halaman detail pesanan (tanpa error)
        return redirect('/checkout/' . $order->invoice_number)
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    // ✅ Halaman sukses (opsional)
    public function success()
    {
        return Inertia::render('Checkout/Success');
    }

    // 📄 Detail pesanan berdasarkan invoice
    public function show($invoice)
    {
        $order = Order::with('items.product')
            ->where('invoice_number', $invoice)
            ->firstOrFail();

        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak punya akses ke pesanan ini.');
        }

        return Inertia::render('Checkout/Detail', [
            'order' => $order,
        ]);
    }
}
