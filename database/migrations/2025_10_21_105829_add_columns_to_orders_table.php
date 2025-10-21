<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
    $table->string('payment_method')->nullable()->after('total_price');
    $table->enum('payment_status', ['unpaid', 'paid', 'refunded'])->default('unpaid')->after('payment_method');
    $table->text('shipping_address')->nullable()->after('payment_status');
    $table->enum('shipping_status', ['pending', 'shipped', 'delivered'])->default('pending')->after('shipping_address');
    $table->text('notes')->nullable()->after('shipping_status');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
