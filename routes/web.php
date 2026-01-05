<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ReceiptController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Authentication routes
Route::get('/login', [LoginController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [LoginController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', [LoginController::class, 'destroy'])
    ->name('logout')
    ->middleware('auth');

// Protected routes - require authentication
Route::middleware(['auth'])->group(function () {
    // Dashboard - All roles
    Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard');

    // POS Routes - All roles
    Route::prefix('pos')->name('pos.')->group(function () {
        Route::get('/', \App\Livewire\POS::class)->name('index');
    });

    // Orders Routes - All roles
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', \App\Livewire\Orders\OrderList::class)->name('index');
        Route::get('/{order}/receipt', [ReceiptController::class, 'show'])->name('receipt.show');
        Route::get('/{order}/receipt/pdf', [ReceiptController::class, 'download'])->name('receipt.download');
        Route::get('/{order}/receipt/print', [ReceiptController::class, 'print'])->name('receipt.print');
    });

    // Customers Routes - All roles
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', \App\Livewire\Customers\CustomerList::class)->name('index');
    });

    // Services Routes - All roles (view), Admin/Manager (manage)
    Route::prefix('services')->name('services.')->group(function () {
        Route::get('/', \App\Livewire\Services\ServiceList::class)->name('index');
    });

    // Settings Routes - Admin only
    Route::prefix('settings')->name('settings.')->middleware('role:admin')->group(function () {
        Route::get('/', \App\Livewire\Settings::class)->name('index');
    });
});
