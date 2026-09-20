<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('post.login');

Route::get('/menu/{table}', [HomeController::class, 'index'])->name('menu');
Route::get('/menu/{table}/order/{product}', [OrderController::class, 'order'])->name('order');
Route::get('/cart/{table}', [OrderController::class, 'index'])->name('cart');
Route::put('/cart/{cart}/update', [OrderController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cart}/destroy', [OrderController::class, 'destroy'])->name('cart.destroy');
Route::get('/place-order/{table}', [OrderController::class, 'placeOrder'])->name('order.place');
Route::get('/bill/{table}', [OrderController::class, 'bill'])->name('bill');
Route::get('/close-bill/{table}', [OrderController::class, 'closeBill'])->name('bill.close');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware(['role:admin,cashier'])->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
    });

    Route::resource('tables', TableController::class);
    Route::get('tables/{table}/qr-code', [TableController::class, 'generateQrCode'])->name('tables.qr-code');

    Route::resource('transactions', TransactionController::class);
    Route::patch('/payment/{transaction}', [TransactionController::class, 'payment'])->name('transactions.payment');

    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
    });

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
