<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Penting: Import Auth
use Carbon\Carbon; // Penting: Import Carbon untuk pengecekan tanggal

class CheckPaymentStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Pastikan pengguna sudah login. Jika belum, arahkan ke halaman login.
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $routeName = $request->route()->getName();

        // Ambil status modul dari User model. Pastikan metode ini sudah diupdate.
        $hasTrulyActiveModule = $user->hasActiveModule(); // Mengecek status 'approved' DAN belum kedaluwarsa/lifetime
        $hasPendingModule = $user->hasPendingModule();   // Mengecek status 'pending'

        // --- Logika Pengalihan Berdasarkan Status Modul dan Rute yang Diakses ---

        // Kondisi 1: Pengguna SUDAH memiliki modul yang aktif (status 'approved' & belum kedaluwarsa/lifetime)
        if ($hasTrulyActiveModule) {
            // Jika user aktif tapi mencoba mengakses rute pemilihan modul atau pembayaran
            // Ini dianggap tidak relevan, jadi arahkan kembali ke dashboard.
            if ($routeName === 'select_module' || str_starts_with($routeName, 'payment')) {
                return redirect()->route('dashboard')->with('info', 'Anda sudah memiliki modul aktif.');
            }
            // Jika user aktif mengakses rute lain (misalnya member area), izinkan akses.
            return $next($request);
        }

        // Kondisi 2: Pengguna memiliki modul yang statusnya 'pending' (menunggu persetujuan admin)
        if ($hasPendingModule) {
            // Jika user pending tapi mencoba mengakses rute pemilihan modul atau pembayaran
            // Ini juga dianggap tidak relevan, arahkan kembali ke dashboard.
            if ($routeName === 'select_module' || str_starts_with($routeName, 'payment')) {
                return redirect()->route('dashboard')->with('info', 'Modul Anda sedang menunggu persetujuan admin.');
            }
            // Jika user pending mencoba mengakses rute lain (misalnya member area),
            // kita blokir akses karena modul belum aktif. Arahkan ke dashboard.
            if ($routeName !== 'dashboard') { // Jangan blokir akses ke dashboard itu sendiri
                 return redirect()->route('dashboard')->with('error', 'Modul Anda belum aktif. Silakan tunggu persetujuan admin.');
            }
            // Jika rute yang diminta adalah dashboard, izinkan.
            return $next($request);
        }

        // Kondisi 3: Pengguna TIDAK memiliki modul aktif maupun pending
        // Ini berarti modulnya belum dipilih sama sekali, sudah kedaluwarsa, atau ditolak.

        // Jika user tidak punya modul aktif/pending TAPI mencoba mengakses rute yang dilindungi
        // Contoh: '/member_area_approved', '/courses'
        // Jika rute bukan 'select_module', bukan 'payment.*', dan bukan 'dashboard',
        // maka arahkan ke halaman expired/informasi untuk memilih modul.
        if ($routeName !== 'select_module' && !str_starts_with($routeName, 'payment') && $routeName !== 'dashboard') {
            return redirect()->route('subscription.expired')->with('error', 'Akses ditolak. Modul Anda belum aktif atau telah kedaluwarsa.');
        }

        // Jika tidak ada kondisi di atas yang memblokir, izinkan akses.
        // Ini akan mengizinkan user untuk mengakses 'select_module', 'payment.*', dan 'dashboard'
        // ketika mereka belum punya modul aktif/pending (agar bisa memilih/memperpanjang).
        return $next($request);
    }
}