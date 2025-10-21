<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
    if (!Schema::hasColumn('orders', 'guest_email')) {
        $table->string('guest_email')->nullable()->after('user_id');
    }
    if (!Schema::hasColumn('orders', 'guest_phone')) {
        $table->string('guest_phone')->nullable()->after('guest_email');
    }
});

    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['guest_name', 'guest_email', 'guest_phone', 'shipping_address']);
        });
    }
};
