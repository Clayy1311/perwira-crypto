<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAdmin
{
    public function handle(Request $request, Closure $next): Response // Pastikan return type adalah Response
    {
        if (!auth()->check()) {
            return redirect()->route('login'); // Redirect ke login jika belum autentikasi
        }
    
        // Debugging: Cek nilai role dan hasil metode isAdmin()
        logger()->info('Admin check', [
            'user' => auth()->user()->email,
            'user_role' => auth()->user()->role, // Log nilai kolom 'role' secara langsung
            'is_admin_check_result' => auth()->user()->isAdmin() // Panggil metode isAdmin()
        ]);
    
        // GANTI INI: Panggil metode isAdmin() dengan tanda kurung ()
        if (!auth()->user()->isAdmin()) { // <--- TAMBAHKAN TANDA KURUNG () DI SINI
            abort(403, 'Unauthorized action. User is not admin');
        }
    
        return $next($request);
    }
}