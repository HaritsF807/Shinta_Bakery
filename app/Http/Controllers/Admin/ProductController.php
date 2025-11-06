<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category; // 1. ✅ TAMBAHKAN IMPORT INI
use Illuminate\Http\Request; // 2. ✅ TAMBAHKAN IMPORT INI
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;


class ProductController extends Controller
{
    /**
     * Ubah method index kamu menjadi seperti ini
     */
    public function index(Request $request) // 3. ✅ INJECT Request
    {
        // 4. ✅ BUAT QUERY BUILDER
        $productsQuery = Product::with('category');

        // 5. ✅ TAMBAHKAN LOGIKA FILTER
        if ($request->filled('category')) {
            $productsQuery->where('category_id', $request->category);
        }

        // 6. ✅ AMBIL HASILNYA
        $products = $productsQuery->latest()->get();

        // 7. ✅ AMBIL SEMUA KATEGORI
        $categories = Category::all();

        // 8. ✅ KIRIM categories & selectedCategory KE VIEW
        return Inertia::render('Admin/Products/Index', [
            'products' => $products,
            'categories' => $categories, // <-- INI YANG HILANG
            'selectedCategory' => $request->category, // <-- Untuk simpan state filter
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
        // PERBAIKAN: Sesuaikan nama kolom validasi
        $validated = $request->validate([
            'name' => 'required|string|max:255', // Ganti dari 'nama_produk'
            'description' => 'nullable|string', // Ganti dari 'deskripsi'
            'price' => 'required|numeric|min:0', // Ganti dari 'harga'
            'stock' => 'required|integer|min:0', // Ganti dari 'stok'
            'status' => 'required|string|in:aktif,nonaktif',
            'category_id' => 'required|integer|exists:categories,id', // Ganti dari 'id_kategori'
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Ganti dari 'url_gambar'
        ]);

        // PERBAIKAN: Sesuaikan logika update gambar
        if ($request->hasFile('image')) { // Ganti dari 'url_gambar'
            
            // Hapus gambar lama jika ada
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            // Simpan gambar baru dan update path-nya
            $path = $request->file('image')->store('products', 'public'); // Ganti dari 'url_gambar'
            $validated['image'] = $path; // Ganti dari 'url_gambar'
        }else {
            // Pastikan front-end tidak menimpa image dengan null/empty
            if (array_key_exists('image', $validated) && is_null($validated['image'])) {
                unset($validated['image']);
            }
        }
        // Update data di database
        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
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
