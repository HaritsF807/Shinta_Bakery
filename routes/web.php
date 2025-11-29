<?php

use App\Models\Category;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\SocialiteController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    $categories = Category::all();
    return Inertia::render('LandingPage', [
        'categories' => $categories,
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

/**
 * Socialite Auth
 */
Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);

// 🌾 Produk Publik
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// 📦 Riwayat Pesanan
Route::get('/history', [OrderController::class, 'history'])->name('orders.history');
Route::get('/history/{invoice}', [OrderController::class, 'guestShow'])->name('history.show');

Route::get('/detail', function () {
    return Inertia::render('DetailTransaksi');
})->name('detail');

// 🛒 Keranjang
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/validate-stock', [CartController::class, 'validateStock'])->name('cart.validate-stock');

// 📄 Katalog
Route::get('/api/catalog-path', [App\Http\Controllers\CatalogController::class, 'getCatalogPath'])->name('catalog.path');

// 🧾 Checkout
Route::get('/checkout', [OrderController::class, 'create'])->name('checkout');
Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success', [OrderController::class, 'success'])->name('checkout.success');
Route::get('/checkout/{invoice}', [OrderController::class, 'show'])->name('checkout.show');

// 🧍‍♀️ User Login (Customer Dashboard)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');
});

// 🌟 Testimoni (Public - Guest bisa submit)
Route::post('/testimonials', [App\Http\Controllers\TestimonialController::class, 'store'])->name('testimonials.store');

// 👮‍♂️ ADMIN PANEL
Route::middleware(['auth', 'verified', 'isAdmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // --- CUSTOM ROUTES (place BEFORE resource to avoid collisions) ---
        // Activate all (only products with stock > 0 will be activated)
        Route::post('products/activate-all', [ProductAdminController::class, 'activateAll'])
            ->name('products.activateAll');

        // Optional: manual deactivate all
        Route::post('products/deactivate-all', [ProductAdminController::class, 'deactivateAllByAdmin'])
            ->name('products.deactivateAll');

        // Optional: activate single product (with optional force)
        Route::post('products/{id}/activate', [ProductAdminController::class, 'activateSingle'])
            ->name('products.activateSingle');

        // Resource controllers (kept after custom routes)
        Route::resource('products', AdminProductController::class);
        Route::resource('categories', CategoryController::class);

        // Route Manajemen Order Admin
        Route::get('/orders', [OrderController::class, 'adminIndex'])->name('orders.index');
        Route::get('/orders/{id}', [OrderController::class, 'adminShow'])->name('orders.show');
        Route::put('/orders/{id}', [OrderController::class, 'adminUpdate'])->name('orders.update');

        // Route Manajemen Testimonials Admin
        Route::get('/testimonials', [App\Http\Controllers\TestimonialController::class, 'adminIndex'])->name('testimonials.index');

        // Route Manajemen Katalog Admin
        Route::post('/catalog/upload', [App\Http\Controllers\CatalogController::class, 'upload'])->name('catalog.upload');

        // Route Profile Admin
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

require __DIR__ . '/auth.php';
