<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Tambahkan ini jika belum ada

class EnsureIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) { // Gunakan Auth::check() untuk konsistensi
            return redirect()->route('login');
        }
    
        $user = Auth::user(); // Dapatkan user yang sedang login
    
        // Debugging: Cek nilai role dan hasil metode isAdmin()
        logger()->info('Admin check in EnsureIsAdmin middleware', [
            'user_email' => $user->email,
            'user_role_from_db' => $user->role, // Log nilai kolom 'role' secara langsung
            'is_admin_method_result' => $user->isAdmin() // Panggil metode isAdmin() dengan TANDA KURUNG
        ]);
    
        // PERBAIKAN PENTING: Panggil metode isAdmin() dengan TANDA KURUNG ()
        if (!$user->isAdmin()) { // <--- INI PERBAIKANNYA!
            // Jika user bukan admin, alihkan ke dashboard user atau rute lain yang sesuai
            // Menggunakan redirect lebih baik daripada abort(403) untuk pengalaman user yang lebih halus
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }
    
        return $next($request);
    }
}