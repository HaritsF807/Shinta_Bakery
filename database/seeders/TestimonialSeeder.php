<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;
use App\Models\Order;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Membuat data dummy testimonials untuk testing
     */
    public function run(): void
    {
        // Ambil order dengan status completed (jika ada)
        $completedOrders = Order::where('status', 'completed')->get();

        if ($completedOrders->isEmpty()) {
            $this->command->warn('⚠️  Tidak ada order dengan status completed. Seeder testimonial dilewati.');
            return;
        }

        $comments = [
            'Roti sangat enak dan fresh! Pengiriman cepat. Terima kasih!',
            'Produknya berkualitas, packaging rapi. Sangat puas!',
            'Harga terjangkau dengan kualitas premium. Recommended!',
            'Pelayanan ramah, produk sesuai ekspektasi. Akan beli lagi!',
            'Enak banget! Anak-anak suka semua. Top deh!',
            'Produk segar dan lembut, sesuai pesanan. Mantap!',
            'Pertama kali beli langsung jatuh cinta. Bakal langganan!',
            'Rasa oke, harga oke, pelayanan oke. Perfect!',
            null, // Ada yang tidak isi komentar
            'Lumayan enak, next time mau coba varian lain.',
        ];

        // Buat testimonial untuk beberapa order completed
        foreach ($completedOrders->take(5) as $index => $order) {
            // Skip jika sudah ada testimonial
            if ($order->testimonial) {
                continue;
            }

            Testimonial::create([
                'order_id' => $order->id,
                'customer_name' => $order->guest_name ?? $order->user?->name ?? 'Customer ' . ($index + 1),
                'rating' => rand(4, 5), // Rating bagus (4-5 bintang)
                'comment' => $comments[array_rand($comments)],
            ]);
        }

        $this->command->info('✅ TestimonialSeeder selesai!');
    }
}
