<?php

use App\Http\Controllers\Superadmin\AdminUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin & Dashboard Routes
|--------------------------------------------------------------------------
|
| Seluruh route di sini dilindungi oleh middleware 'auth' dan 'verified'
| yang dipasang pada import di routes/web.php.
|
*/

// Halaman Dashboard Utama (Umum untuk Superadmin & Admin)
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Kelompok Route Khusus Superadmin
Route::middleware(['superadmin'])->group(function () {
    
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
