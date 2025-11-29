<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * 
     * Tabel testimonials untuk menyimpan rating & komentar dari pelanggan
     * setelah pesanan selesai (status = completed)
     */
    public function up(): void {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('customer_name', 255);
            $table->integer('rating'); // 1-5 bintang
            $table->text('comment')->nullable();
            $table->timestamps(); // created_at, updated_at

            // Index untuk performa query
            $table->index('order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('testimonials');
    }
};
