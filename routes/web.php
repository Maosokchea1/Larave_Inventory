<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\StockAdjustmentController;
use App\Http\Controllers\StockTransferController;
use App\Http\Controllers\StockReportController;
use App\Http\Controllers\Admin\UserController; 
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ConnectAdminController;
use App\Http\Controllers\ProductSettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect Route (/) ទៅកាន់ទំព័រ Login ភ្លាមៗ
Route::get('/', function () {
    return redirect()->route('login');
});

// Language Switcher Route
Route::get('/language/{locale}', function (string $locale) {
    if (! in_array($locale, ['en', 'km'], true)) {
        abort(404);
    }

    session(['locale' => $locale]);

    return back()->withCookie(cookie()->forever('locale', $locale));
})->name('language.switch');

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Notifications Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
});

// Settings Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings');
    Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');
});

// Password Update Route
Route::middleware('auth')->group(function () {
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
});

// General Resources (Protected by Auth)
Route::middleware(['auth'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SuppliersController::class);
    Route::resource('products', ProductsController::class);
});

// Stock In/Out, Adjustments & Transfers
Route::middleware(['auth'])->group(function () {
    Route::get('/stock/in', [StockInController::class, 'index'])->name('stock.in');
    Route::post('/stock/in', [StockInController::class, 'store'])->name('stock.in.store');

    Route::get('/stock/out', [StockOutController::class, 'index'])->name('stock.out');
    Route::post('/stock/out', [StockOutController::class, 'store'])->name('stock.out.store');

    Route::get('/stock/adjustments', [StockAdjustmentController::class, 'index'])->name('stock.adjustments');
    Route::post('/stock/adjustments', [StockAdjustmentController::class, 'store'])->name('stock.adjustments.store');

    // Stock Transfer Routes
    Route::get('/stock/transfer', [StockTransferController::class, 'index'])->name('stock.transfer.index');
    Route::get('/stock/transfer/create', [StockTransferController::class, 'create'])->name('stock.transfer.create');
    Route::post('/stock/transfer', [StockTransferController::class, 'store'])->name('stock.transfer.store');
    Route::get('/stock/transfer/{id}/edit', [StockTransferController::class, 'edit'])->name('stock.transfer.edit');
    Route::put('/stock/transfer/{id}', [StockTransferController::class, 'update'])->name('stock.transfer.update');
    Route::delete('/stock/transfer/{id}', [StockTransferController::class, 'destroy'])->name('stock.transfer.destroy');
});

// Report for stock and export to excel & pdf
Route::middleware(['auth'])->group(function () {
    Route::get('/stock/reports', [StockReportController::class, 'index'])->name('stock.reports');
    Route::get('/stock/reports/export', [StockReportController::class, 'exportExcel'])->name('stock.reports.export');
    Route::get('/stock/reports/pdf', [StockReportController::class, 'pdf'])->name('stock.reports.pdf');
});

// ==========================================
// Admin Management Group Routes (Protected by admin middleware)
// ==========================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Roles Management
    Route::resource('roles', RoleController::class);

    // Permissions Management
    Route::name('permissions.')->group(function () {
        Route::get('/permissions', [PermissionController::class, 'index'])->name('index');
        Route::get('/permissions/create', [PermissionController::class, 'create'])->name('create');
        Route::post('/permissions', [PermissionController::class, 'store'])->name('store');
    });
});

// ==========================================
// Users & Connect Admin Routes (Accessible by regular authenticated users)
// ==========================================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Users Management
    Route::resource('users', UserController::class);

    // Connect Admin Route
    Route::resource('connect-admin', ConnectAdminController::class);
});

// Product Settings routes
Route::middleware(['auth'])->group(function () {
    Route::resource('products-settings', ProductSettingController::class);
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';