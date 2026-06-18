<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Superadmin\AdminUserController;
use App\Http\Controllers\Superadmin\SuperadminController;
use App\Http\Controllers\Superadmin\UnitController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\SchoolProfileController;
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\ExtracurricularController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\SpmbController;
use App\Http\Controllers\Admin\MajorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin & Dashboard Routes
|--------------------------------------------------------------------------
|
| Seluruh route di sini dilindungi oleh middleware 'auth' dan 'verified'
| yang dipasang pada import di routes/web.php.
|
|*/

// Pengalihan Cerdas Dashboard Berdasarkan Peran (F4-01)
Route::get('/dashboard', DashboardController::class)->name('dashboard');

// Kelompok Route Khusus Admin Unit (F5-00)
Route::middleware(['auth', 'admin.unit'])->prefix('admin/{unit:slug}')->name('admin.')->group(function () {
    // Dashboard Admin Unit (F5-01)
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Modul Profil Sekolah (F5-04)
    Route::get('profile', [SchoolProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [SchoolProfileController::class, 'update'])->name('profile.update');
    
    // Modul Kesiswaan (F5-10, F5-13)
    Route::resource('achievements', AchievementController::class)->except(['show']);
    Route::resource('extracurriculars', ExtracurricularController::class)->except(['show']);
    
    // Modul Publikasi (F5-16, F5-21, F5-26)
    Route::resource('news', NewsController::class)->except(['show']);
    Route::resource('galleries', GalleryController::class)->except(['show']);
    Route::resource('majors', MajorController::class)->except(['show']);
    Route::get('spmb', [SpmbController::class, 'edit'])->name('spmb.edit');
    Route::put('spmb', [SpmbController::class, 'update'])->name('spmb.update');
});

// Kelompok Route Khusus Superadmin
Route::middleware(['superadmin'])->group(function () {
    
    // Dasbor Overview Global Superadmin (F4-02)
    Route::get('superadmin/dashboard', [SuperadminController::class, 'index'])->name('superadmin.dashboard');
    
    // CRUD Manajemen Unit Sekolah (F4-04)
    Route::resource('superadmin/units', UnitController::class)->names([
        'index'   => 'superadmin.units.index',
        'create'  => 'superadmin.units.create',
        'store'   => 'superadmin.units.store',
        'show'    => 'superadmin.units.show',
        'edit'    => 'superadmin.units.edit',
        'update'  => 'superadmin.units.update',
        'destroy' => 'superadmin.units.destroy',
    ]);
    
    // CRUD Manajemen Admin & User
    Route::resource('superadmin/users', AdminUserController::class)->names([
        'index'   => 'superadmin.users.index',
        'create'  => 'superadmin.users.create',
        'store'   => 'superadmin.users.store',
        'edit'    => 'superadmin.users.edit',
        'update'  => 'superadmin.users.update',
        'destroy' => 'superadmin.users.destroy',
    ])->except(['show']);
    
});

