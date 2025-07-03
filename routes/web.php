<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\CooperativeController as AdminCooperativeController;
use App\Http\Controllers\Anggota\CooperativeController as AnggotaCooperativeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\SppController as AdminSppController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Pelatih\SppController as PelatihSppController;
use App\Http\Controllers\Pelatih\AttendanceController as PelatihAttendanceController;
use App\Http\Controllers\Anggota\SppController as AnggotaSppController;
use App\Http\Controllers\Anggota\AttendanceController as AnggotaAttendanceController;
use App\Http\Controllers\Shared\ShopController;

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
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard Routes with Role-based Access
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');

        // Admin Routes - Full Access
        Route::resource('admin/users', UserController::class, ['as' => 'admin']);
        Route::resource('admin/locations', LocationController::class, ['as' => 'admin']);
        Route::resource('admin/members', MemberController::class, ['as' => 'admin']);
        Route::resource('admin/announcements', AnnouncementController::class, ['as' => 'admin']);

        // Koperasi Routes
        Route::prefix('cooperative')->name('cooperative.')->group(function () {
            Route::get('/', [AdminCooperativeController::class, 'index'])->name('index');
            Route::get('/member-savings', [AdminCooperativeController::class, 'memberSavings'])->name('member-savings');
            Route::get('/member-savings/{member}', [AdminCooperativeController::class, 'showMemberSavings'])->name('member-savings.show');
            Route::post('/member-savings/{member}', [AdminCooperativeController::class, 'storeMemberSavings'])->name('member-savings.store');
            Route::post('/member-savings/{member}/loan', [AdminCooperativeController::class, 'createLoan'])->name('member-savings.loan');
        });

        // Product Management Routes
        Route::resource('products', ProductController::class, ['as' => 'admin']);
        Route::post('products/{product}/update-stock', [ProductController::class, 'updateLocationStock'])->name('admin.products.update-stock');

        // Sales Management Routes
        Route::resource('sales', SalesController::class, ['as' => 'admin']);
        Route::get('sales/location/{location}/products', [SalesController::class, 'getProductsByLocation'])->name('admin.sales.location-products');

        // SPP Management Routes
        Route::prefix('spp')->name('spp.')->group(function () {
            Route::get('/', [AdminSppController::class, 'index'])->name('index');
            Route::get('/payments', [AdminSppController::class, 'payments'])->name('payments');
            Route::get('/create', [AdminSppController::class, 'create'])->name('create');
            Route::post('/', [AdminSppController::class, 'store'])->name('store');
            Route::get('/{spp}/edit', [AdminSppController::class, 'edit'])->name('edit');
            Route::put('/{spp}', [AdminSppController::class, 'update'])->name('update');
            Route::post('/{spp}/process-payment', [AdminSppController::class, 'processPayment'])->name('process-payment');
            Route::post('/generate-bulk', [AdminSppController::class, 'generateBulkSpp'])->name('generate-bulk');
            Route::get('/reports', [AdminSppController::class, 'reports'])->name('reports');
            Route::get('/member/{member}/history', [AdminSppController::class, 'memberHistory'])->name('member-history');
        });

        // Schedule Management Routes
        Route::resource('schedules', ScheduleController::class, ['as' => 'admin']);
        Route::get('schedules/{schedule}/attendance', [ScheduleController::class, 'attendanceForm'])->name('admin.schedules.attendance');
        Route::post('schedules/generate-recurring', [ScheduleController::class, 'generateRecurring'])->name('admin.schedules.generate-recurring');

        // Attendance Management Routes
        Route::prefix('attendance')->name('attendance.')->group(function () {
            Route::get('/', [AdminAttendanceController::class, 'index'])->name('index');
            Route::get('/attendances', [AdminAttendanceController::class, 'attendances'])->name('attendances');
            Route::get('/create', [AdminAttendanceController::class, 'create'])->name('create');
            Route::post('/', [AdminAttendanceController::class, 'store'])->name('store');
            Route::get('/{attendance}/edit', [AdminAttendanceController::class, 'edit'])->name('edit');
            Route::put('/{attendance}', [AdminAttendanceController::class, 'update'])->name('update');
            Route::delete('/{attendance}', [AdminAttendanceController::class, 'destroy'])->name('destroy');
            Route::get('/reports', [AdminAttendanceController::class, 'reports'])->name('reports');
            Route::get('/member/{member}/history', [AdminAttendanceController::class, 'memberHistory'])->name('member-history');
            Route::post('/schedule/{schedule}/bulk', [AdminAttendanceController::class, 'bulkAttendance'])->name('bulk');
        });
    });

    Route::middleware(['role:pelatih'])->group(function () {
        Route::get('/pelatih/dashboard', [DashboardController::class, 'pelatih'])->name('pelatih.dashboard');

        // Shop Routes for Pelatih
        Route::prefix('shop')->name('pelatih.shop.')->group(function () {
            Route::get('/', [ShopController::class, 'index'])->name('index');
            Route::get('/product/{product}', [ShopController::class, 'show'])->name('show');
            Route::post('/cart/add/{product}', [ShopController::class, 'addToCart'])->name('cart.add');
            Route::get('/cart', [ShopController::class, 'cart'])->name('cart');
            Route::post('/cart/update', [ShopController::class, 'updateCart'])->name('cart.update');
            Route::delete('/cart/remove/{product}', [ShopController::class, 'removeFromCart'])->name('cart.remove');
            Route::post('/checkout', [ShopController::class, 'checkout'])->name('checkout');
        });

        // SPP Routes for Pelatih
        Route::prefix('spp')->name('pelatih.spp.')->group(function () {
            Route::get('/', [PelatihSppController::class, 'index'])->name('index');
            Route::get('/payments', [PelatihSppController::class, 'payments'])->name('payments');
            Route::post('/{spp}/process-payment', [PelatihSppController::class, 'processPayment'])->name('process-payment');
            Route::get('/member/{member}/history', [PelatihSppController::class, 'memberHistory'])->name('member-history');
            Route::get('/reports', [PelatihSppController::class, 'reports'])->name('reports');
        });

        // Attendance Routes for Pelatih
        Route::prefix('attendance')->name('pelatih.attendance.')->group(function () {
            Route::get('/', [PelatihAttendanceController::class, 'index'])->name('index');
            Route::get('/attendances', [PelatihAttendanceController::class, 'attendances'])->name('attendances');
            Route::get('/create', [PelatihAttendanceController::class, 'create'])->name('create');
            Route::post('/', [PelatihAttendanceController::class, 'store'])->name('store');
            Route::get('/{attendance}/edit', [PelatihAttendanceController::class, 'edit'])->name('edit');
            Route::put('/{attendance}', [PelatihAttendanceController::class, 'update'])->name('update');
            Route::get('/reports', [PelatihAttendanceController::class, 'reports'])->name('reports');
            Route::get('/member/{member}/history', [PelatihAttendanceController::class, 'memberHistory'])->name('member-history');
            Route::get('/schedule/{schedule}/attendance', [PelatihAttendanceController::class, 'attendanceForm'])->name('schedule.attendance');
            Route::post('/schedule/{schedule}/bulk', [PelatihAttendanceController::class, 'bulkAttendance'])->name('bulk');
        });
    });

    Route::middleware(['role:anggota', 'member.access'])->group(function () {
        Route::get('/anggota/dashboard', [DashboardController::class, 'anggota'])->name('anggota.dashboard');

        // Koperasi Routes for Anggota
        Route::prefix('cooperative')->name('anggota.cooperative.')->group(function () {
            Route::get('/', [AnggotaCooperativeController::class, 'index'])->name('index');
            Route::get('/payment', [AnggotaCooperativeController::class, 'showPaymentForm'])->name('payment');
            Route::post('/payment', [AnggotaCooperativeController::class, 'processPayment'])->name('payment.process');
        });

        // Shop Routes for Anggota
        Route::prefix('shop')->name('anggota.shop.')->group(function () {
            Route::get('/', [ShopController::class, 'index'])->name('index');
            Route::get('/product/{product}', [ShopController::class, 'show'])->name('show');
            Route::post('/cart/add/{product}', [ShopController::class, 'addToCart'])->name('cart.add');
            Route::get('/cart', [ShopController::class, 'cart'])->name('cart');
            Route::post('/cart/update', [ShopController::class, 'updateCart'])->name('cart.update');
            Route::delete('/cart/remove/{product}', [ShopController::class, 'removeFromCart'])->name('cart.remove');
            Route::post('/checkout', [ShopController::class, 'checkout'])->name('checkout');
        });

        // SPP Routes for Anggota
        Route::prefix('spp')->name('anggota.spp.')->group(function () {
            Route::get('/', [AnggotaSppController::class, 'index'])->name('index');
            Route::get('/{spp}/payment', [AnggotaSppController::class, 'showPaymentForm'])->name('payment');
            Route::post('/{spp}/payment', [AnggotaSppController::class, 'processPayment'])->name('payment.process');
            Route::get('/{spp}/receipt', [AnggotaSppController::class, 'downloadReceipt'])->name('receipt');
        });

        // Attendance Routes for Anggota
        Route::prefix('attendance')->name('anggota.attendance.')->group(function () {
            Route::get('/', [AnggotaAttendanceController::class, 'index'])->name('index');
            Route::get('/schedules', [AnggotaAttendanceController::class, 'schedules'])->name('schedules');
            Route::get('/schedule/{schedule}', [AnggotaAttendanceController::class, 'showSchedule'])->name('schedule.show');
            Route::get('/monthly-summary', [AnggotaAttendanceController::class, 'monthlySummary'])->name('monthly-summary');
            Route::get('/certificate', [AnggotaAttendanceController::class, 'certificate'])->name('certificate');
        });
    });



    // General dashboard fallback
    Route::get('/dashboard', function () {
        $user = auth()->user();
        switch ($user->role->name) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'pelatih':
                return redirect()->route('pelatih.dashboard');
            case 'anggota':
                return redirect()->route('anggota.dashboard');
            default:
                abort(403, 'Role tidak dikenali.');
        }
    })->name('dashboard');
});
