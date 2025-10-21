<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use Inertia\Inertia;

// 🌐 Halaman awal (public)
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// 🧍‍♀️ ROUTE UNTUK USER BIASA (auth wajib)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🧑‍💼 ROUTE UNTUK ADMIN (auth + verified + isAdmin)
Route::middleware(['auth', 'verified', 'isAdmin'])
    ->prefix('admin')
    ->name('admin.') // gunakan name() bukan as(), biar lebih Laravel-standard
    ->group(function () {

        // Dashboard admin
        Route::get('/dashboard', function () {
            return Inertia::render('Admin/Dashboard');
        })->name('dashboard');

        // CRUD Produk
        Route::resource('products', ProductController::class);

        //CRUD Kategrori
        Route::resource('categories', CategoryController::class);
    });

require __DIR__ . '/auth.php';
