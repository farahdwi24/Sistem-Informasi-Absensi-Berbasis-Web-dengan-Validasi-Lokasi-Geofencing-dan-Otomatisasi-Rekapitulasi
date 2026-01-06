<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\ApprovalController;
use App\Http\Controllers\Admin\ReportController;

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/absensi', [AttendanceController::class, 'index'])->name('absensi.index'); 
    Route::post('/absensi', [AttendanceController::class, 'store'])->name('absensi.store'); 

    Route::get('/pengajuan/buat', [SubmissionController::class, 'create'])->name('pengajuan.create');
    Route::post('/pengajuan', [SubmissionController::class, 'store'])->name('pengajuan.store');

    Route::get('/absensi/{attendance}/edit', [DashboardController::class, 'editAbsensi'])
         ->name('admin.absensi.edit');
    Route::put('/absensi/{attendance}', [DashboardController::class, 'updateAbsensi'])
         ->name('admin.absensi.update');
    Route::delete('/absensi/{attendance}', [DashboardController::class, 'destroyAbsensi'])
           ->name('admin.absensi.destroy');
});



Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::resource('users', UserController::class);

    Route::resource('locations', LocationController::class);

    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [ReportController::class, 'exportExcel'])->name('laporan.export');

    Route::get('/pengajuan/create', [ApprovalController::class, 'createPengajuan'])
         ->name('pengajuan.create');
    Route::post('/pengajuan', [ApprovalController::class, 'storePengajuan'])
         ->name('pengajuan.store');

    Route::get('/persetujuan', [ApprovalController::class, 'index'])->name('persetujuan.index');
    Route::post('/persetujuan/{attendance}/approve', [ApprovalController::class, 'approve'])->name('persetujuan.approve');
    Route::post('/persetujuan/{attendance}/reject', [ApprovalController::class, 'reject'])->name('persetujuan.reject');

});