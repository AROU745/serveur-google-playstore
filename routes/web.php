<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InvoiceController as AdminInvoiceController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\ConsoleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/pricing', [HomeController::class, 'pricing'])->name('pricing');
Route::get('/console', [ConsoleController::class, 'index'])->name('console');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/refund-policy', [HomeController::class, 'refundPolicy'])->name('refund');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::get('/payment', [PaymentController::class, 'show'])->name('payment');
Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/pending', [PaymentController::class, 'pending'])->name('payment.pending');
Route::get('/payment/failed', [PaymentController::class, 'failed'])->name('payment.failed');
Route::post('/payment/pending/proof', [PaymentController::class, 'submitProof'])->name('payment.proof');

Route::get('/order/{order_number}', [OrderController::class, 'show'])->name('order.show');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
        Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers');
        Route::get('/invoices', [AdminInvoiceController::class, 'index'])->name('invoices');
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings');
        Route::put('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
    });
});
