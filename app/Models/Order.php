<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'guest_name',
    'guest_email',
    'guest_phone',
    'shipping_address',
    'total_price',
    'status',
    'payment_method',
    'payment_status',
    'shipping_status',
    'notes',
];


    // 🧭 Relasi: 1 order dimiliki oleh 1 user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 📦 Relasi: 1 order punya banyak item
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
