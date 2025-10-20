<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();

        return Inertia::render('Admin/Products/Index', [
            'products' => $products,
        ]);
    }

    public function create()
{
    $categories = \App\Models\Category::select('id', 'name')->get();

    return Inertia::render('Admin/Products/Create', [
        'categories' => $categories,
    ]);
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|string|in:aktif,nonaktif',
            'category_id' => 'required|integer|exists:categories,id',
            'image' => 'nullable|image|max:5120', // max 5MB
        ]);

        // handle image upload
        if ($request->hasFile('image')) {
            // store in storage/app/public/products
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        Product::create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }
    public function edit($id)
{
    $product = \App\Models\Product::findOrFail($id);
    $categories = \App\Models\Category::all();

    return Inertia::render('Admin/Products/Edit', [
        'product' => $product,
        'categories' => $categories,
    ]);
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'status' => 'required|string|in:aktif,nonaktif',
        'category_id' => 'required|integer|exists:categories,id',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $product = \App\Models\Product::findOrFail($id);

    // kalau ada upload gambar baru
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $validated['image'] = $path;
    }

    $product->update($validated);

    return redirect()
        ->route('admin.products.index')
        ->with('success', 'Produk berhasil diperbarui.');
}

public function destroy($id)
{
    $product = Product::findOrFail($id);

    // Hapus gambar kalau ada
    if ($product->image && Storage::disk('public')->exists($product->image)) {
        Storage::disk('public')->delete($product->image);
    }

    $product->delete();

    return redirect()
        ->route('admin.products.index')
        ->with('success', 'Produk berhasil dihapus.');
}


}
