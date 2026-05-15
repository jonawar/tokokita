<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SitemapController;

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/products/import', [\App\Http\Controllers\AdminProductController::class, 'import'])->name('admin.products.import');
    Route::get('/admin/products/download-template', [\App\Http\Controllers\AdminProductController::class, 'downloadTemplate'])->name('admin.products.download-template');
    Route::resource('/admin/products', \App\Http\Controllers\AdminProductController::class)->names([
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'show' => 'admin.products.show',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ]);
    Route::resource('/admin/categories', \App\Http\Controllers\AdminCategoryController::class)->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);
    Route::resource('/admin/suppliers', \App\Http\Controllers\AdminSupplierController::class)->names([
        'index' => 'admin.suppliers.index',
        'create' => 'admin.suppliers.create',
        'store' => 'admin.suppliers.store',
        'edit' => 'admin.suppliers.edit',
        'update' => 'admin.suppliers.update',
        'destroy' => 'admin.suppliers.destroy',
    ]);

    // Admin Order Management
    Route::get('/admin/orders', [\App\Http\Controllers\AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [\App\Http\Controllers\AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::patch('/admin/orders/{order}', [\App\Http\Controllers\AdminOrderController::class, 'update'])->name('admin.orders.update');

    // Admin Settings
    Route::get('/admin/settings', [\App\Http\Controllers\AdminSettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/admin/settings', [\App\Http\Controllers\AdminSettingController::class, 'update'])->name('admin.settings.update');
});

Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('orders.store');

    // User Order History
    Route::get('/orders', [\App\Http\Controllers\UserOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\UserOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/confirm-payment', [\App\Http\Controllers\UserOrderController::class, 'confirmPayment'])->name('orders.confirm-payment');

    // User Profile
    Route::get('/profile', [\App\Http\Controllers\UserProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [\App\Http\Controllers\UserProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [\App\Http\Controllers\UserProfileController::class, 'updatePassword'])->name('profile.password.update');
});

require __DIR__ . '/auth.php';
