<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
  'category_id',
  'name',
  'description',
  'price',
  'stock',
  'image',
  'status',
];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
