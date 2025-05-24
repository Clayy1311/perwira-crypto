<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate(); // Otentikasi pengguna
        $request->session()->regenerate(); // Regenerasi session untuk keamanan

        $user = Auth::user(); // Dapatkan objek pengguna yang baru saja login

        // --- INI ADALAH LOGIKA PENTINGNYA ---
        // PRIORITAS 1: Cek apakah pengguna adalah admin. Ini HARUS DULUAN.
        if ($user && $user->isAdmin()) {
            return redirect()->route('admin.dashboard'); // Jika admin, LANGSUNG arahkan ke admin.dashboard
        }

        // PRIORITAS 2: Jika BUKAN admin, maka arahkan ke dashboard pengguna biasa.
        // DashboardController (yang sudah kita perbaiki) akan menangani logika lebih lanjut
        // (apakah user approved, pending, atau perlu memilih modul).
        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
