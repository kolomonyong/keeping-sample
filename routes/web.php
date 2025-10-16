<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\DefectiveProductController;
use App\Http\Controllers\ScanController;


Route::get('/', function () {
    return redirect()->route('login');
});

// Middleware 'verified' dihapus dari grup ini
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute yang bisa diakses semua role (tampilan read-only untuk user)
    Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
    Route::get('/defective-reports', [DefectiveProductController::class, 'index'])->name('defective-reports.index');

    // Rute khusus Admin
    Route::middleware(['role:admin'])->group(function () {
        Route::post('/dashboard/cleanup-expired', [DashboardController::class, 'cleanupExpired'])->name('dashboard.cleanup-expired');
        Route::post('/dashboard/cleanup-expiring-soon', [DashboardController::class, 'cleanupExpiringSoon'])->name('dashboard.cleanup-expiring-soon');
        Route::resource('stocks', StockController::class)->except(['index', 'show']);
        Route::get('/stocks/{stock}/report-deviation', [StockController::class, 'showReportDeviationForm'])->name('stocks.report-deviation.form');
        Route::post('/stocks/{stock}/report-deviation', [StockController::class, 'storeReportDeviation'])->name('stocks.report-deviation.store');
        Route::post('/defective-reports/{report}/confirm', [DefectiveProductController::class, 'confirm'])->name('defective-reports.confirm');
    });

    // Rute Stok yang bisa diakses semua role
    Route::get('stocks/{stock}/print-barcode', [StockController::class, 'printBarcode'])->name('stocks.print-barcode');
    Route::get('stocks/{stock}/history', [StockController::class, 'history'])->name('stocks.history');

    // Route::resource('product-types', ProductTypeController::class)->except('show');

    // Rute untuk Scan (Hanya untuk Admin)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/scan', [ScanController::class, 'showScanPage'])->name('scan.page');
        Route::get('/scan/camera', [ScanController::class, 'showCameraPage'])->name('scan.camera');
        Route::post('/scan/process', [ScanController::class, 'processScan'])->name('scan.process');
    });
});

require __DIR__ . '/auth.php';
