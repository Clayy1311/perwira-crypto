<?php
namespace App\Http\Controllers;

use App\Models\UserModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show($moduleType)
    {
        // Pastikan user belum punya modul
        if (auth()->user()->hasActiveModule()) {
            return redirect()->route('dashboard');
        }

        // Validasi tipe modul
        if (!in_array($moduleType, ['lifetime', 'monthly'])) {
            return redirect()->route('module.select')->with('error', 'Pilihan modul tidak valid');
        }

        return view('payment.show', [
            'moduleType' => $moduleType
        ]);
    }

    public function process(Request $request)
    {
        // Pastikan user belum punya modul
        if (auth()->user()->hasActiveModule()) {
            return redirect()->route('dashboard');
        }

        $request->validate([
            'module_type' => 'required|in:lifetime,monthly',
            'payment_method' => 'required|string',
        ]);

        // Simpan data modul user
        UserModule::create([
            'user_id' => auth()->id(),
            'module_type' => $request->module_type,
            'expiry_date' => $request->module_type == 'lifetime' ? null : now()->addMonth(),
            'payment_method' => $request->payment_method,
            'amount' => $request->module_type == 'lifetime' ? 500000 : 100000,
           'status' => 'inactive', // nonaktif sampai disetujui
        'status_approved' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Pembayaran berhasil!');
    }
}