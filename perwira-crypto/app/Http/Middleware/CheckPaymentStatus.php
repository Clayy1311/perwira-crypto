<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPaymentStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Jika user SUDAH memiliki modul (baik aktif maupun pending),
        // dan user mencoba mengakses rute 'select_module' atau 'payment.*'
        if (($user->hasActiveModule() || $user->hasPendingModule()) &&
            ($request->route()->getName() === 'select_module' || str_starts_with($request->route()->getName(), 'payment'))) {
            
            // Karena kita ingin mereka ke dashboard untuk melihat status, arahkan saja ke dashboard.
            return redirect()->route('dashboard');
        }

        // Jika user belum punya modul ATAU sedang mengakses rute lain (bukan select_module/payment),
        // izinkan untuk melanjutkan.
        return $next($request);
    }
}