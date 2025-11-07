<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category; // ⬅ tambahkan ini
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua kategori untuk filter
        $categories = Category::all();

        // Query dasar produk
        $query = Product::with('category')->orderBy('created_at', 'desc');

        // Jika ada parameter ?category=id, filter produk berdasarkan kategori
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Ambil hasil akhir
        $products = $query->get();

        // Kirim data ke frontend
        return Inertia::render('Products/Index', [
            'products' => $products->values(),
            'categories' => $categories,
            'selectedCategory' => $request->category, // untuk tahu kategori aktif
        ]);
        
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        return Inertia::render('Products/Show', [
            'product' => $product,
        ]);
    }
}