<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPaymentStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        // Perbaikan 1: Gunakan auth() dengan benar
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Perbaikan 2: Gunakan exists() dengan query builder
        if (auth()->user()->modules()->exists()) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}