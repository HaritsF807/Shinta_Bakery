<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\Order;
use Inertia\Inertia;

class TestimonialController extends Controller
{
    /**
     * 💾 Store testimonial baru dari user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // 🔍 Cek apakah order sudah punya testimonial
        $existingTestimonial = Testimonial::where('order_id', $validated['order_id'])->first();
        
        if ($existingTestimonial) {
            return back()->with('error', 'Anda sudah memberikan testimoni untuk pesanan ini.');
        }

        // 🔍 Ambil order untuk customer_name
        $order = Order::findOrFail($validated['order_id']);
        $customerName = $order->guest_name ?? $order->user?->name ?? 'Customer';

        // 💾 Simpan testimonial
        Testimonial::create([
            'order_id' => $validated['order_id'],
            'customer_name' => $customerName,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return back()->with('success', 'Terima kasih atas testimoni Anda! 🙏');
    }

    /**
     * 📋 Admin: Lihat semua testimonials
     */
    public function adminIndex()
    {
        $testimonials = Testimonial::with(['order.items.product'])
            ->latest()
            ->paginate(20);

        return Inertia::render('Admin/Testimonials/Index', [
            'testimonials' => $testimonials->through(fn ($testimonial) => [
                'id' => $testimonial->id,
                'invoice_number' => $testimonial->order->invoice_number,
                'customer_name' => $testimonial->customer_name,
                'rating' => $testimonial->rating,
                'comment' => $testimonial->comment,
                'products' => $testimonial->order->items->map(fn ($item) => $item->product?->name ?? 'Produk')->toArray(),
                'created_at' => $testimonial->created_at->diffForHumans(),
            ]),
        ]);
    }
}
