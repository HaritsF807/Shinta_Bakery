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
            'guest_name'        => 'nullable|string|max:255',
            'guest_email'       => 'nullable|email|max:255',
            'guest_phone'       => 'required|string|max:30',
            'shipping_address'  => 'required|string|max:500',
            'payment_method'    => 'required|in:cod,transfer',
        ]);

        // 🔢 Hitung jumlah pesanan hari ini
        $today = now()->format('Y-m-d');
        $orderCountToday = Order::whereDate('created_at', $today)->count() + 1;

        // 🧾 Generate kode invoice, misal: INV-0211202501
        $invoiceNumber = 'INV-' . now()->format('dmY') . str_pad($orderCountToday, 2, '0', STR_PAD_LEFT);

        // hitung total dengan fallback untuk 'qty'
        $totalPrice = collect($cart)->sum(function ($item) {
            $qty = (int) ($item['quantity'] ?? $item['qty'] ?? 1);
            return ($item['price'] ?? 0) * $qty;
        });
        // 🧍 Buat order baru
        $order = Order::create([
            'invoice_number'   => $invoiceNumber,
            'user_id'          => Auth::id() ?? null, // guest juga bisa
            'guest_name'       => $validated['guest_name'] ?? null,
            'guest_email'      => $validated['guest_email'] ?? null,
            'guest_phone'      => $validated['guest_phone'] ?? null,
            'shipping_address' => $validated['shipping_address'] ?? null,
            'payment_method'   => $validated['payment_method'],
            'total_price'      => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
            'status'           => 'pending',
        ]);

        // 💽 Simpan item pesanan
         foreach ($cart as $item) {
            $quantity = (int) ($item['quantity'] ?? $item['qty'] ?? 1);
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item['id'],
                'quantity'   => $quantity,
                'price'      => $item['price'],
                'subtotal'   => ($item['price'] ?? 0) * $quantity,
                'status'     => 'pending',
            ]);
        }

        // 🧹 Kosongkan keranjang
        session()->forget('cart');

        // 🚀 Arahkan ke halaman detail pesanan (DetailTransaksi.vue)
        return redirect("/history/{$order->invoice_number}")
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    // ✅ Halaman sukses (opsional)
    public function success()
    {
        return Inertia::render('Checkout/Success');
    }

    // 📄 Detail pesanan (untuk user login)
    public function show($invoice)
    {
        $order = Order::with('items.product')
            ->where('invoice_number', $invoice)
            ->firstOrFail();

        if (Auth::check() && $order->user_id && $order->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak punya akses ke pesanan ini.');
        }

        return Inertia::render('Checkout/Detail', [
            'order' => $order,
        ]);
    }

    // 🧾 Riwayat pesanan (tanpa login, bisa cari pakai no HP / invoice)
    public function history(Request $request)
    {
        $query = Order::query();

        // Filter pencarian (no HP, invoice, atau status)
        if ($search = $request->get('search')) {
            $query->where('guest_phone', 'like', "%{$search}%")
                  ->orWhere('invoice_number', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return Inertia::render('HistoryPembeli', [
            'orders' => $orders,
            'filters' => [
                'search' => $search
            ],
        ]);
    }

    // 📜 Detail pesanan untuk guest (tanpa login)
    public function guestShow($invoice)
    {
        $order = Order::with(['items.product'])
            ->where('invoice_number', $invoice)
            ->firstOrFail();

        return Inertia::render('DetailTransaksi', [
            'order' => $order,
        ]);
    }

    // 📦 Daftar pesanan untuk admin
    public function adminIndex()
    {
        $orders = Order::with('user')->latest()->paginate(10);

        return Inertia::render('Admin/Orders/Index', [
            'orders' => $orders->through(fn ($order) => [
                'id' => $order->id,
                'invoice_number' => $order->invoice_number,
                'customer_name' => $order->user?->name ?? $order->guest_name, // ✅ fleksibel
                'total_price' => $order->total_price,
                'status' => $order->status,
                'payment_status' => $order->payment_status,
            ]),
        ]);
    }

    // 🔍 Detail pesanan untuk admin
    public function adminShow($id)
    {
        $order = Order::with('items.product', 'user')->findOrFail($id);
        
        return Inertia::render('Admin/Orders/Show', [
            'order' => $order,
        ]);
    }

    // 🔄 Update status pesanan oleh admin
    public function adminUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,completed,cancelled',
            'payment_status' => 'required|string|in:unpaid,paid,failed'
        ]);

        $order = Order::findOrFail($id);
        
        $order->update([
            'status' => $validated['status'],
            'payment_status' => $validated['payment_status']
        ]);

        
        // ✅ KODE BARU (Gunakan ini):
        // Arahkan kembali ke halaman detail admin untuk order yang sama
        return redirect()
            ->route('admin.orders.show', $order->id) 
            ->with('success', 'Status pesanan berhasil diperbarui!');
    }

}
