<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage; // ⬅️ PENTING: Untuk mengelola file

class ProductController extends Controller
{
    /**
     * Menampilkan daftar semua produk (halaman katalog admin).
     */
    public function index(Request $request)
    {
        $categories = Category::all();

        $query = Product::with('category')->orderBy('created_at', 'desc');

        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Gunakan paginate() untuk halaman yang lebih cepat, bukan get()
        $products = $query->paginate(10)->withQueryString();

        return Inertia::render('Admin/Products/Index', [ // Pastikan path Inertia-mu benar
            'products' => $products,
            'categories' => $categories,
            'filters' => ['category' => $request->category],
        ]);
    }

    /**
     * Menampilkan form untuk membuat produk baru.
     */
    public function create()
    {
        $categories = Category::all();
        return Inertia::render('Admin/Products/Create', [ // Pastikan path Inertia-mu benar
            'categories' => $categories,
        ]);
    }

    /**
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:aktif,nonaktif',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048', // 'required' saat buat baru
        ]);

        // Simpan gambar
        $path = $request->file('image')->store('products', 'public');
        $validated['image'] = $path; // Simpan path-nya ke data divalidasi

        Product::create($validated);

        return redirect()->route('admin.products.index') // Asumsi nama route-nya ini
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit produk.
     * (Fungsi ini yang dipanggil untuk membuka halaman Edit Produk-mu)
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        // Ini adalah halaman .vue yang kamu kirimkan tadi
        return Inertia::render('Admin/Products/Edit', [ 
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    /**
     * 🚀 INI ADALAH FUNGSI YANG HILANG 🚀
     * Memperbarui produk di database.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // 1. Validasi data (gambar 'nullable' karena mungkin tidak diubah)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:aktif,nonaktif',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // ⬅️ 'nullable'
        ]);

        // 2. Cek apakah ada file gambar BARU yang di-upload
        if ($request->hasFile('image')) {
            
            // 3. Hapus gambar LAMA (jika ada)
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            // 4. Simpan gambar BARU dan dapatkan path-nya
            $path = $request->file('image')->store('products', 'public');
            
            // 5. Update data 'image' di $validated dengan path baru
            $validated['image'] = $path;
        }

        // 6. Update produk di database
        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Menghapus produk dari database.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus gambar dari storage
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Hapus data dari database
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}