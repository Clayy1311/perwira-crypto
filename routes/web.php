<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ModuleApprovalController;
// Jangan lupa import controller yang lain jika ada (misal User\PaymentStatusController jika masih digunakan)
use App\Http\Controllers\User; // Import namespace User jika User\PaymentStatusController ada di sana

use Illuminate\Support\Facades\Route;

// Rute untuk Halaman Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Mengimpor Rute Otentikasi (login, register, dll.) dari file terpisah
require __DIR__.'/auth.php';



// Grup Rute Admin
// Middleware 'auth' memastikan user sudah login.
// Middleware 'admin' (EnsureIsAdmin) memastikan user memiliki peran admin.
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard Admin, menampilkan daftar modul yang perlu disetujui
    Route::get('/dashboard', [ModuleApprovalController::class, 'index'])->name('admin.dashboard');

    // Rute untuk menyetujui atau menolak modul
    // 'module' akan otomatis di-resolve menjadi objek UserModule
    Route::put('/module-approvals/{module}', [ModuleApprovalController::class, 'approve'])
         ->name('admin.module-approvals.update');
    Route::delete('/module-approvals/{module}', [ModuleApprovalController::class, 'reject'])
         ->name('admin.module-approvals.destroy');
});



// Grup Rute Pengguna Terautentikasi dan Terverifikasi
// Middleware 'auth' memastikan user sudah login.
// Middleware 'verified' memastikan user sudah memverifikasi emailnya.
// Middleware 'payment.check' (CheckPaymentStatus) akan menangani semua logika akses modul:
//   - Mengizinkan akses jika modul aktif (approved dan belum kedaluwarsa/lifetime).
//   - Mengarahkan ke dashboard jika mencoba memilih/bayar padahal sudah aktif/pending.
//   - Mengarahkan ke halaman expired jika tidak aktif/pending dan mencoba akses konten.
Route::middleware(['auth', 'verified', 'payment.check'])->group(function () {

    // Dashboard Pengguna
    // Middleware 'payment.check' akan mengarahkan sesuai status modul pengguna.
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute Pemilihan Modul
    // Middleware 'payment.check' akan memblokir akses ke sini jika user sudah punya modul aktif/pending.
    Route::get('/select_module', [ModuleController::class, 'select'])->name('select_module');
    Route::post('/select_module/process', [ModuleController::class, 'processSelection'])->name('select_module.process');

    // Rute Pembayaran Modul
    // Middleware 'payment.check' akan memblokir akses ke sini jika user sudah punya modul aktif/pending.
    Route::get('/payment/{module}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');

    // Rute Status Pembayaran (jika masih digunakan, pastikan User\PaymentStatusController ada)
    // Jika logika pengecekannya sudah dihandle payment.check, mungkin ini bisa dihapus atau diintegrasikan
    // ke DashboardController. Untuk saat ini, kita biarkan di sini.
    Route::get('/payment/status', [User\PaymentStatusController::class, 'status'])
         ->name('payment.status');

    // Rute untuk Area Member/Konten Modul yang Dilindungi
    // Middleware 'payment.check' akan memastikan hanya user dengan modul aktif yang bisa akses.
    Route::get('/member_area_approved', function() {
        // Logika pengecekan modul sudah dilakukan di middleware 'payment.check'.
        // Jika kode sampai sini, berarti user memiliki modul yang aktif.
        return view('user.approved_modul');
    })->name('member_area_approved');

    // Tambahkan rute konten atau fitur lain yang memerlukan modul aktif di sini
    // Contoh: Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
});



// Rute Halaman Modul Kedaluwarsa/Tidak Aktif
// Rute ini HARUS BISA diakses oleh user yang sudah login, terlepas dari status modul mereka,
// karena ini adalah halaman tujuan redirect jika modul tidak aktif.
Route::get('/subscription-expired', function () {
    return view('module.select');
})->name('subscription.expired');