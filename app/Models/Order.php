<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'user_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'shipping_address',
        'payment_method',
        'total_price',
        'status',
        'payment_status',
        'shipping_status',
        'notes',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
