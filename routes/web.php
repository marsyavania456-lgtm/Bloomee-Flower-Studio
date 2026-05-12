<?php

use App\Http\Controllers\AdminTransactionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Awal → Redirect ke Login
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => redirect('/login'));

/*
|--------------------------------------------------------------------------
| Routes yang membutuhkan Login
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // ── Dashboard ──────────────────────────────────────────────────────────
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ── Profile (Breeze) ───────────────────────────────────────────────────
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ── Shop / Toko ────────────────────────────────────────────────────────
    Route::get('/shop', [ProductController::class, 'shop'])->name('shop');

    // ── Keranjang ─────────────────────────────────────────────────────────
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{productId}', [CartController::class, 'update'])->name('cart.update');
    Route::get('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // ── Transaksi User ────────────────────────────────────────────────────
    Route::get('/transaksi', [TransactionController::class, 'index'])->name('transaksi.index');
    Route::post('/transaksi/checkout', [TransactionController::class, 'checkout'])->name('transaksi.checkout');
    Route::get('/transaksi/{transaction}', [TransactionController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/{transaction}/cetak', [TransactionController::class, 'cetak'])->name('transaksi.cetak');

    // ── Notifikasi ────────────────────────────────────────────────────────
    Route::get('/notifikasi/{id}/read', [TransactionController::class, 'readNotification'])->name('notifikasi.read');
    Route::get('/notifikasi/read-all', [TransactionController::class, 'readAllNotifications'])->name('notifikasi.readAll');

    // ── Admin Only ────────────────────────────────────────────────────────
    Route::middleware(['auth', 'admin'])->group(function () {


        // Produk (CRUD)
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        // Admin Transaksi
        Route::get('/admin/transaksi', [AdminTransactionController::class, 'index'])->name('admin.transaksi.index');
        Route::get('/admin/transaksi/{transaction}', [AdminTransactionController::class, 'show'])->name('admin.transaksi.show');
        Route::post('/admin/transaksi/{transaction}/status', [AdminTransactionController::class, 'updateStatus'])->name('admin.transaksi.status');

        // Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/excel', [LaporanController::class, 'exportExcel'])->name('laporan.excel');
        Route::get('/laporan/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');

        // Data User
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/users/{user}/reset', [UserController::class, 'resetPassword'])->name('users.reset');
    });
});

require __DIR__ . '/auth.php';