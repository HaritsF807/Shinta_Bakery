<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return inertia('Cart/Index', ['cart' => $cart]);
    }

    public function add(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $cart = session()->get('cart', []);

    // ambil qty dari request, default 1
    $quantity = max((int) $request->input('quantity', 1), 1);

    if (isset($cart[$id])) {
        // kalau produk sudah ada, tambahkan sesuai qty
        $cart[$id]['quantity'] += $quantity;
    } else {
        // kalau belum ada, tambahkan produk baru ke keranjang
        $cart[$id] = [
            'id'       => $product->id,
            'name'     => $product->name,
            'price'    => $product->price,
            'quantity' => $quantity,
            'image'    => $product->image ?? null,
        ];
    }

    session()->put('cart', $cart);

    // respons inertial atau redirect tergantung kebutuhan
    return redirect()->route('cart.index')
        ->with('success', "{$product->name} (x{$quantity}) berhasil ditambahkan ke keranjang!");
}


    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang dikosongkan.');
    }
    public function updateQuantity(Request $request, $id)
{
    $cart = session()->get('cart', []);
    $quantity = max((int) $request->input('quantity', 1), 1);

    if (isset($cart[$id])) {
        $cart[$id]['quantity'] = $quantity; // langsung set ke nilai baru
        session()->put('cart', $cart);
        return back()->with('success', "Jumlah produk diperbarui!");
    }

    return back()->with('error', "Produk tidak ditemukan di keranjang.");
}
    
}
