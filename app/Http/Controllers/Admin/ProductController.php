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

/**
     * Memperbarui data produk di database.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'status' => 'required|string',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'url_gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Validasi untuk gambar
        ]);

        $data = $request->except('_token', '_method'); // Ambil semua data kecuali token

        // Cek apakah ada file gambar baru yang di-upload
        if ($request->hasFile('url_gambar')) {
            // Hapus gambar lama jika ada (opsional, tapi disarankan)
            // if ($produk->url_gambar) {
            //     Storage::delete($produk->url_gambar);
            // }

            // Simpan gambar baru dan update path-nya
            $path = $request->file('url_gambar')->store('public/produk');
            $data['url_gambar'] = $path;
        }

        $product->update($data);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui.');
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
