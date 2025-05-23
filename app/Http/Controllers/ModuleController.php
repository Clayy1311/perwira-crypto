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
}
