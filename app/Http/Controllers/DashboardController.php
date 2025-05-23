<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Pastikan user sudah punya modul
        if (!auth()->user()->hasActiveModule()) {
            return redirect()->route('select_module');
        }

        $activeModule = auth()->user()->modules()->latest()->first();

        return view('dashboard', [
            'activeModule' => $activeModule
        ]);
    }
}