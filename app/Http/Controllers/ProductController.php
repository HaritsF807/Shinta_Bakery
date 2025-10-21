<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        // urutkan: produk aktif dan stok > 0 di atas, sisanya di bawah
        $products = Product::orderByRaw("
            CASE 
                WHEN status = 'aktif' AND stock > 0 THEN 1
                ELSE 2
            END
        ")->latest()->get();

        return Inertia::render('Products/Index', [
            'products' => $products,
        ]);
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return Inertia::render('Products/Show', ['product' => $product]);
    }
}
