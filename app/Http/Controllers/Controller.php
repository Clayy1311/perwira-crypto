<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function select()
    {
        // Hanya bisa diakses oleh user yang belum punya modul
        if (auth()->user()->hasActiveModule()) {
            return redirect()->route('dashboard');
        }

        return view('modules.select');
    }
}
