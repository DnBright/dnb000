<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\CustomerAuthController;
use Illuminate\Support\Facades\Route;

// ================= CUSTOMER =================
Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');

// ================= CUSTOMER LOGIN/DASHBOARD =================
Route::get('/login', [CustomerAuthController::class,'showLogin'])->name('login');
Route::post('/login', [CustomerAuthController::class,'login'])->name('login.submit');
Route::get('/dashboard', function(){ return view('home'); })->name('dashboard');

// ================= ADMIN LOGIN =================
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ================= ADMIN DASHBOARD =================
// tanpa middleware  akses bebas
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

// route lain
Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
Route::get('/admin/customers', [AdminUserController::class, 'index'])->name('admin.customers');

