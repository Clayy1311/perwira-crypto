<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApprovedModule
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
{
    if (!auth()->user()->modules()->where('status_approved', 'approved')->exists()) {
        return redirect()->route('payment.status')->with('error', 'Anda belum memiliki modul yang disetujui');
    }

    return $next($request);
}
}
