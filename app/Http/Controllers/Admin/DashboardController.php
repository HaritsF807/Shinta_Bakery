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
                    'stock' => $product->stock,
                    'status' => $product->status, // aktif atau nonaktif
                    'available' => $product->stock > 0 && $product->status === 'aktif',
                    'image' => $product->image ? "/storage/{$product->image}" : 'https://placehold.co/200x200/png?text=Produk',
                    'total_sold' => $item->total_sold
                ];
            })->filter()->values();

        // 6. Ambil 5 Testimoni Terbaru
        $reviews = \App\Models\Testimonial::with(['order.items.product'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($testimonial) {
                // Ambil produk pertama untuk gambar (atau bisa agregasi semua produk)
                $firstProduct = $testimonial->order->items->first()?->product;
                
                return [
                    'id' => $testimonial->id,
                    'product_name' => $testimonial->order->items->pluck('product.name')->filter()->implode(', ') ?: 'Produk',
                    'user_name' => $testimonial->customer_name,
                    'rating' => $testimonial->rating,
                    'comment' => $testimonial->comment ?? '',
                    'image' => $firstProduct?->image_url ?? 'https://placehold.co/60x60/png?text=Produk',
                ];
            });

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
            'catalogInfo' => app(\App\Http\Controllers\CatalogController::class)->getInfo(),
        ]);
    }
}