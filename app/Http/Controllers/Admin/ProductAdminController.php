<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Product;

class ProductAdminController extends Controller
{
    // optional: kalau belum, pastikan middleware isAdmin dipasang di route group
    // public function __construct() {
    //     $this->middleware(['auth','isAdmin']);
    // }

    /**
     * Nonaktifkan semua produk (manual oleh admin).
     */
    public function deactivateAllByAdmin(Request $request)
    {
        Log::info('Admin deactivating all products', ['admin_id' => $request->user()?->id]);

        $affected = Product::where('status', 'aktif')->update(['status' => 'nonaktif']);

        // jika request Inertia/AJAX, redirect back tetap bekerja
        return back()->with('success', "{$affected} produk dinonaktifkan.");
    }

    /**
     * Aktifkan semua produk yang nonaktif dan punya stok > 0.
     */
    public function activateAll(Request $request)
    {
        Log::info('Admin activating products', ['admin_id' => $request->user()?->id]);

        $affected = Product::where('status', 'nonaktif')
            ->where('stock', '>', 0)
            ->update(['status' => 'aktif']);

        return back()->with('success', "{$affected} produk berhasil diaktifkan.");
    }

    /**
     * Opsional: aktifkan single product (force)
     */
    public function activateSingle(Request $request, $id)
    {
        $force = (bool) $request->input('force', false);

        $product = Product::findOrFail($id);

        if (! $force && $product->stock <= 0) {
            return back()->with('error', 'Produk tidak punya stok — gunakan force untuk override.');
        }

        $product->update(['status' => 'aktif']);

        Log::info('Admin activated single product', [
            'admin_id' => $request->user()?->id,
            'product_id' => $product->id,
            'force' => $force,
        ]);

        return back()->with('success', "Produk \"{$product->name}\" diaktifkan.");
    }
}
