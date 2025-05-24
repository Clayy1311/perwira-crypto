<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ModuleApprovalController; // <-- Tambahkan ini
use App\http\Controllers\Admin\ModuleContentController;

use App\Http\Controllers\Admin\ModuleController as AdminModuleController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rute untuk autentikasi (login/register) - tetap pertahankan
require __DIR__.'/auth.php';



// routes pengecekan udah approve atau belum
Route::middleware(['auth'])->get('/member_area_approved', function() {
    // Cek apakah user punya minimal 1 modul approved
    $hasApprovedModule = auth()->user()
        ->modules()
        ->where('status_approved', 'approved')
        ->exists();

    if (!$hasApprovedModule) {
        return redirect('/')->with('error', 'Anda belum memiliki modul yang disetujui');
    }

    return view('user.approved_modul');
})->name('member_area_approved');




// User routes
Route::middleware(['auth'])->group(function () {
    Route::get('/payment/status', [User\PaymentStatusController::class, 'status'])
         ->name('payment.status');
});



// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard admin menampilkan modul yang menunggu persetujuan
    Route::get('/dashboard', [ModuleApprovalController::class, 'index'])->name('admin.dashboard');

    // Rute untuk approve dan reject
    Route::put('/module-approvals/{module}', [ModuleApprovalController::class, 'approve'])
         ->name('admin.module-approvals.update');
    Route::delete('/module-approvals/{module}', [ModuleApprovalController::class, 'reject'])
         ->name('admin.module-approvals.destroy');

    // CRUD module oleh admin (gunakan controller yang khusus)
    Route::resource('modules', AdminModuleController::class)
         ->names('admin.modules');

   // Isi dari modul atau modul content
    Route::resource('modules.module_contents', ModuleContentController::class)
    ->names('admin.module_contents');

});



// Rute setelah login (User umum)
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard - kita modifikasi menggunakan controller
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes - pertahankan yang sudah ada
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rute baru untuk modul dan pembayaran
    Route::middleware('payment.check')->group(function () {
        // Pilih modul - kita gunakan controller
        Route::get('/select_module', [ModuleController::class, 'select'])->name('select_module');
        
        // Proses pembayaran
        Route::get('/payment/{module}', [PaymentController::class, 'show'])->name('payment.show');
        Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
    });
});