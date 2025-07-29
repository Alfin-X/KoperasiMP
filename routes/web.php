<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');

        // User Management
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);

        // Kolat Management
        Route::resource('kolats', App\Http\Controllers\Admin\KolatController::class);

        // Schedule & Attendance Management
        Route::resource('schedules', App\Http\Controllers\Admin\ScheduleController::class);
        Route::get('/attendance', [App\Http\Controllers\Admin\ScheduleController::class, 'attendance'])->name('attendance.index');
        Route::get('/attendance/{schedule}', [App\Http\Controllers\Admin\ScheduleController::class, 'attendanceDetail'])->name('attendance.detail');

        // SPP Management
        Route::resource('spp', App\Http\Controllers\Admin\SppController::class);
        Route::post('/spp/generate', [App\Http\Controllers\Admin\SppController::class, 'generateBills'])->name('spp.generate');
        Route::patch('/spp/{payment}/verify', [App\Http\Controllers\Admin\SppController::class, 'verifyPayment'])->name('spp.verify');

        // Koperasi Management
        Route::resource('koperasi', App\Http\Controllers\Admin\KoperasiController::class);
        Route::get('/koperasi/transactions/pending', [App\Http\Controllers\Admin\KoperasiController::class, 'pendingTransactions'])->name('koperasi.pending');
        Route::patch('/koperasi/transactions/{transaction}/approve', [App\Http\Controllers\Admin\KoperasiController::class, 'approveTransaction'])->name('koperasi.approve');
        Route::patch('/koperasi/transactions/{transaction}/reject', [App\Http\Controllers\Admin\KoperasiController::class, 'rejectTransaction'])->name('koperasi.reject');
        Route::post('/koperasi/transactions/add', [App\Http\Controllers\Admin\KoperasiController::class, 'addTransaction'])->name('koperasi.add-transaction');

        // Simpanan Anggota Management
        Route::get('/simpanan-anggota', [App\Http\Controllers\Admin\SimpananAnggotaController::class, 'index'])->name('simpanan-anggota.index');
        Route::get('/simpanan-anggota/{user}', [App\Http\Controllers\Admin\SimpananAnggotaController::class, 'show'])->name('simpanan-anggota.show');
        Route::post('/simpanan-anggota/{user}/transactions', [App\Http\Controllers\Admin\SimpananAnggotaController::class, 'storeTransaction'])->name('simpanan-anggota.store-transaction');
        Route::put('/simpanan-anggota/transactions/{transaction}', [App\Http\Controllers\Admin\SimpananAnggotaController::class, 'updateTransaction'])->name('simpanan-anggota.update-transaction');
        Route::delete('/simpanan-anggota/transactions/{transaction}', [App\Http\Controllers\Admin\SimpananAnggotaController::class, 'deleteTransaction'])->name('simpanan-anggota.delete-transaction');

        // E-commerce Management
        Route::resource('ecommerce', App\Http\Controllers\Admin\EcommerceController::class);
        Route::get('/ecommerce/orders', [App\Http\Controllers\Admin\EcommerceController::class, 'orders'])->name('ecommerce.orders');
        Route::patch('/ecommerce/orders/{order}/status', [App\Http\Controllers\Admin\EcommerceController::class, 'updateOrderStatus'])->name('ecommerce.orders.status');
    });

    // Pelatih Routes
    Route::middleware(['role:pelatih'])->prefix('pelatih')->name('pelatih.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'pelatihDashboard'])->name('dashboard');

        // Anggota Kolat Management
        Route::resource('anggota', App\Http\Controllers\Pelatih\AnggotaController::class);

        // Absensi Management
        Route::resource('absensi', App\Http\Controllers\Pelatih\AbsensiController::class);
        Route::get('/absensi/create/{schedule}', [App\Http\Controllers\Pelatih\AbsensiController::class, 'createForSchedule'])->name('absensi.create.schedule');
        Route::post('/absensi/bulk', [App\Http\Controllers\Pelatih\AbsensiController::class, 'bulkStore'])->name('absensi.bulk');

        // Transaksi Koperasi
        Route::resource('transaksi-koperasi', App\Http\Controllers\Pelatih\TransaksiKoperasiController::class);
        Route::get('/transaksi-koperasi/pending', [App\Http\Controllers\Pelatih\TransaksiKoperasiController::class, 'pending'])->name('transaksi-koperasi.pending');
    });

    // Anggota Routes
    Route::middleware(['role:anggota'])->prefix('anggota')->name('anggota.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'anggotaDashboard'])->name('dashboard');

        // Profile Management
        Route::get('/profile', [App\Http\Controllers\Anggota\ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [App\Http\Controllers\Anggota\ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [App\Http\Controllers\Anggota\ProfileController::class, 'update'])->name('profile.update');

        // Jadwal Latihan
        Route::resource('jadwal', App\Http\Controllers\Anggota\JadwalController::class);
        Route::get('/jadwal/my-schedule', [App\Http\Controllers\Anggota\JadwalController::class, 'mySchedule'])->name('jadwal.my');

        // SPP Management
        Route::resource('spp', App\Http\Controllers\Anggota\SppController::class);
        Route::get('/spp/bills', [App\Http\Controllers\Anggota\SppController::class, 'bills'])->name('spp.bills');
        Route::post('/spp/{bill}/pay', [App\Http\Controllers\Anggota\SppController::class, 'pay'])->name('spp.pay');

        // Simpanan Management
        Route::resource('simpanan', App\Http\Controllers\Anggota\SimpananController::class);
        Route::get('/simpanan/balance', [App\Http\Controllers\Anggota\SimpananController::class, 'balance'])->name('simpanan.balance');
        Route::get('/simpanan/history', [App\Http\Controllers\Anggota\SimpananController::class, 'history'])->name('simpanan.history');

        // Belanja/E-commerce
        Route::resource('belanja', App\Http\Controllers\Anggota\BelanjaController::class);
        Route::get('/belanja/cart', [App\Http\Controllers\Anggota\BelanjaController::class, 'cart'])->name('belanja.cart');
        Route::post('/belanja/add-to-cart', [App\Http\Controllers\Anggota\BelanjaController::class, 'addToCart'])->name('belanja.add-cart');
        Route::get('/belanja/checkout', [App\Http\Controllers\Anggota\BelanjaController::class, 'checkout'])->name('belanja.checkout');
        Route::post('/belanja/order', [App\Http\Controllers\Anggota\BelanjaController::class, 'order'])->name('belanja.order');
    });

});
