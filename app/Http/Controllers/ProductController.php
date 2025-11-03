<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();

        return Inertia::render('Products/Index', [
            'products' => $products
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