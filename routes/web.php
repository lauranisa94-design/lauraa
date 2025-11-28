<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Halaman login (guest)
Route::get('/', function () {
    return view('auth.login');
});

// Dashboard pengguna (autentikasi & verifikasi)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Group route untuk user yang sudah login
Route::middleware('auth')->group(function () {

    // Profil user
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Absensi user
    Route::get('/attendance', [\App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/checkin', [\App\Http\Controllers\AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('/attendance/checkout', [\App\Http\Controllers\AttendanceController::class, 'checkOut'])->name('attendance.checkout');
});

// Group route khusus admin (middleware auth + is_admin)
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::get('/attendance-report', [\App\Http\Controllers\Admin\AttendanceReportController::class, 'index'])->name('attendance-report');
        Route::get('/attendance-report/export', [\App\Http\Controllers\Admin\AttendanceReportController::class, 'exportCSV'])->name('attendance-export');
        Route::get('/monthly-summary', [\App\Http\Controllers\Admin\AttendanceReportController::class, 'monthlySummary'])->name('monthly-summary');
    });

require __DIR__ . '/auth.php';
