<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'customer_name',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    // 🔗 Relasi: setiap testimonial milik satu order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
