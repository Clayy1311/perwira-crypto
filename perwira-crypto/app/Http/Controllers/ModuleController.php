<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModuleController extends Controller
{
    // ...
public function processSelection(Request $request)
{
    // ... (validasi dan penyimpanan UserModule)

    $userModule->status_approved = 'pending'; // Pastikan ini diset!
    $userModule->save();

    // Redirect ke dashboard, di mana DashboardController akan menampilkan status pending
    return redirect()->route('dashboard')->with('success', 'Modul Anda telah berhasil dipilih dan sedang menunggu persetujuan admin.');
}

public function __construct()
    {
        $this->middleware(['auth', 'approved.module']);
    }

    // Hanya tampilkan modul milik user yang sudah approved
    public function index()
    {
        $modules = auth()->user()
            ->modules()
            ->where('status_approved', 'approved')
            ->with('module') // Relasi ke tabel modules
            ->get();

        return view('modules.index', compact('modules'));
    }

}
