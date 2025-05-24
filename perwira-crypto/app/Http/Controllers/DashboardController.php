w<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View // Ini akan selalu menampilkan view, bukan redirect
    {
        $user = auth()->user();

        // Cek status modul user
        if ($user->hasActiveModule()) {
            // Jika modul sudah aktif (approved), tampilkan dashboard dengan modul aktif
            $activeModule = $user->modules()->where('status_approved', 'approved')->latest()->first();
            return view('dashboard', [ // Asumsi 'dashboard.blade.php' adalah untuk modul aktif
                'activeModule' => $activeModule
            ]);
        } elseif ($user->hasPendingModule()) {
            // Jika modul pending, tampilkan dashboard dengan status pending
            $pendingModule = $user->modules()->where('status_approved', 'pending')->latest()->first();
            return view('dashboard', [ // Atau Anda bisa buat view terpisah seperti 'dashboard_pending.blade.php'
                'pendingModule' => $pendingModule,
                'statusMessage' => 'Modul Anda telah dipilih dan sedang menunggu persetujuan admin.'
            ]);
        } else {
            // Jika user belum punya modul (baik aktif maupun pending), arahkan untuk memilih
            return view('dashboard', [ // Asumsi 'dashboard.blade.php' bisa menampilkan tombol 'Pilih Modul'
                'noModule' => true,
                'statusMessage' => 'Anda belum memilih modul. Silakan pilih modul untuk memulai.'
            ]);
        }
    }

    // Metode moduleStatus ini TIDAK LAGI DIPAKAI untuk redirect dari DashboardController::index
    // Tapi bisa tetap ada jika ada rute langsung ke sana.
    // Namun, jika semua penanganan status ada di index(), metode ini bisa dipertimbangkan untuk dihapus
    // atau diubah untuk tujuan lain.
    // public function moduleStatus(): View
    // {
    //     // ... (kode yang Anda punya sebelumnya di sini)
    // }
}