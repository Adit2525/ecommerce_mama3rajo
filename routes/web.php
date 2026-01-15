<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\ShippingRateController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MidtransController;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    // Get best-selling products (highlight/best seller) based on total sold quantity
    $products = Product::where('is_active', 1)
        ->select('produk.*')
        ->leftJoin('pesanan_detail', 'produk.id', '=', 'pesanan_detail.produk_id')
        ->leftJoin('pesanan', function($join) {
            $join->on('pesanan_detail.pesanan_id', '=', 'pesanan.id')
                 ->whereIn('pesanan.status', ['diproses', 'dikirim', 'selesai']);
        })
        ->groupBy('produk.id')
        ->orderByRaw('COALESCE(SUM(pesanan_detail.jumlah), 0) DESC')
        ->take(8)
        ->get();

    return view('welcome', compact('products'));
})->name('welcome');

// Shop routes
Route::get('/shop', [\App\Http\Controllers\ProductController::class, 'index'])->name('shop.index');
Route::get('/shop/search', [\App\Http\Controllers\ProductController::class, 'search'])->name('shop.search');
Route::get('/shop/{product}', [\App\Http\Controllers\ProductController::class, 'show'])->name('shop.show');

// Cart routes
Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'store'])->name('cart.add');
Route::patch('/cart/{key}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{key}', [\App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');
Route::delete('/cart', [\App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');

// Static pages
Route::view('/about', 'about')->name('about');

// Midtrans notification callback (must be public - no auth)
Route::post('/midtrans/notification', [MidtransController::class, 'notification'])->name('midtrans.notification');

// Auth routes (public)
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

// Auth routes (protected)
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    Route::get('/profile/orders/{order}', [ProfileController::class, 'orderShow'])->name('profile.order.show');
    Route::delete('/profile/password-request', [ProfileController::class, 'cancelPasswordRequest'])->name('profile.cancel-password-request');

    // Invoice route
    Route::get('/invoice/{order}', [\App\Http\Controllers\InvoiceController::class, 'show'])->name('invoice.show');

    // Payment routes
    Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{order}/confirm', [PaymentController::class, 'confirm'])->name('payment.confirm');
    Route::get('/payment/{order}/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/{order}/finish', [MidtransController::class, 'finish'])->name('payment.finish');

    // Midtrans routes
    Route::post('/midtrans/snap-token', [MidtransController::class, 'createSnapToken'])->name('midtrans.snap-token');
    Route::post('/midtrans/update-status', [MidtransController::class, 'updatePaymentStatus'])->name('midtrans.update-status');
});

// Admin routes (protected by auth + role middleware)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('products', ProductController::class);
    Route::resource('promotions', PromotionController::class);
    Route::resource('shipping-rates', ShippingRateController::class);
    
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
    Route::post('orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
    Route::get('reports/yearly', [ReportController::class, 'yearly'])->name('reports.yearly');
    Route::get('reports/top-products', [ReportController::class, 'topProducts'])->name('reports.top_products');
    
    Route::post('import/preview', [ImportController::class, 'previewCSV'])->name('import.preview');
    Route::post('import/commit', [ImportController::class, 'commitCSV'])->name('import.commit');
    
    // User management routes
    Route::get('users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::post('users/{user}/verify', [\App\Http\Controllers\Admin\UserController::class, 'verify'])->name('users.verify');
    Route::post('users/{user}/unverify', [\App\Http\Controllers\Admin\UserController::class, 'unverify'])->name('users.unverify');
    Route::post('users/{user}/send-reset-link', [\App\Http\Controllers\Admin\UserController::class, 'sendResetLink'])->name('users.send-reset-link');
    Route::post('users/{user}/reset-password', [\App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::delete('users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
    
    // Password change request routes
    Route::get('password-requests', [\App\Http\Controllers\Admin\PasswordRequestController::class, 'index'])->name('password-requests.index');
    Route::post('password-requests/{passwordRequest}/approve', [\App\Http\Controllers\Admin\PasswordRequestController::class, 'approve'])->name('password-requests.approve');
    Route::post('password-requests/{passwordRequest}/reject', [\App\Http\Controllers\Admin\PasswordRequestController::class, 'reject'])->name('password-requests.reject');
});

