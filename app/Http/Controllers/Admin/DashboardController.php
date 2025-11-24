<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman Dashboard Admin dengan data real.
     */
    public function index()
    {
        // 1. Hitung Income Bulan Ini (Status: completed)
        $incomeThisMonth = Order::where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_price');

        // 2. Hitung TOTAL Item Terjual (Semua Waktu)
        $shipmentThisMonth = OrderItem::whereHas('order', function ($query) {
        $query->where('status', 'completed'); // Hanya hitung yang sudah selesai
    })
    ->sum('quantity');

        // 3. Hitung Pesanan Pending
        $shipmentPending = Order::whereIn('status', ['pending', 'processing'])->count();

        // 4. Ambil 5 Pesanan Pending Terbaru
        $pendingOrders = Order::where('status', 'pending')
            ->with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->invoice_number,
                    'customer' => $order->user ? $order->user->name : ($order->guest_name ?? 'Guest'),
                    'date' => $order->created_at->format('Y-m-d'),
                    'amount' => 'Rp ' . number_format($order->total_price, 0, ',', '.'),
                    'status' => ucfirst($order->status),
                ];
            });

        // 5. Ambil 5 Produk Best Seller
        $bestSellers = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->whereHas('order', function($q) {
                $q->where('status', 'completed');
            })
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->with('product')
            ->get()
            ->map(function ($item) {
                $product = $item->product;
                if (!$product) return null;

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => 'Rp ' . number_format($product->price, 0, ',', '.'),
                    'rating' => 5, // Placeholder
                    'available' => $product->stock > 0,
                    'image' => $product->image_url ?? 'https://placehold.co/200x200/png?text=Produk',
                    'total_sold' => $item->total_sold
                ];
            })->filter()->values();

        // 6. Reviews (Kosongkan dulu)
        $reviews = [];

        // Kirim data ke Frontend (Inertia)
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'incomeThisMonth' => 'Rp ' . number_format($incomeThisMonth, 0, ',', '.'),
                'shipmentThisMonth' => $shipmentThisMonth . ' pcs',
                'shipmentPending' => $shipmentPending,
            ],
            'pendingOrders' => $pendingOrders,
            'reviews' => $reviews,
            'bestSellers' => $bestSellers,
        ]);
    }
}