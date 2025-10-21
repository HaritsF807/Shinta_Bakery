<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\ProductController;   // untuk customer (public)
use App\Http\Controllers\OrderController;      // untuk checkout
use App\Http\Controllers\CartController;       // untuk keranjang
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// 🌐 Halaman Awal (Public)
Route::get('/', function () {
    return Inertia::render('LandingPage', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// 🌾 Produk Publik (Customer)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// 🕓 History Pembeli (opsional untuk user)
Route::get('/history', function () {
    return Inertia::render('HistoryPembeli');
})->name('history');

// 🛒 Keranjang (bisa guest / tanpa login)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// 🧾 Checkout (bisa guest / tanpa login)
Route::get('/checkout', [OrderController::class, 'create'])->name('checkout');
Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success', [OrderController::class, 'success'])->name('checkout.success');

// 🧍‍♀️ ROUTE UNTUK USER LOGIN
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');

    // Profil User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🧑‍💼 ROUTE UNTUK ADMIN
Route::middleware(['auth', 'verified', 'isAdmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', fn() => Inertia::render('Admin/Dashboard'))->name('dashboard');

        // CRUD Produk
        Route::resource('products', AdminProductController::class);

        // CRUD Kategori
        Route::resource('categories', CategoryController::class);
    });

require __DIR__ . '/auth.php';
