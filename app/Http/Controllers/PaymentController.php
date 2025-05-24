<?php

namespace App\Http\Controllers;

use App\Models\UserModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Pastikan Carbon di-import untuk penggunaan now() dan addYears()

class PaymentController extends Controller
{
    /**
     * Menampilkan halaman pemilihan modul pembayaran.
     * User tidak boleh mengakses ini jika sudah punya modul aktif.
     */
    public function show($moduleType)
    {
        // Pastikan user belum punya modul aktif sebelum memilih yang lain
        // Middleware 'payment.check' sudah menangani ini di level rute,
        // tapi validasi ganda tidak ada salahnya jika rute diakses langsung.
        if (auth()->user()->hasActiveModule()) {
            return redirect()->route('dashboard')->with('info', 'Anda sudah memiliki modul aktif.');
        }

        // Validasi tipe modul yang diminta di URL
        // Sesuaikan dengan tipe modul yang Anda tawarkan (e.g., 'lifetime', 'yearly')
        if (!in_array($moduleType, ['lifetime', 'yearly'])) { // <--- Pastikan 'yearly' ada di sini
            return redirect()->route('select_module')->with('error', 'Pilihan modul tidak valid.');
        }

        return view('payment.show', [
            'moduleType' => $moduleType
        ]);
    }

    /**
     * Memproses permintaan pembayaran dan menyimpan modul ke database.
     * Module akan diset sebagai 'pending' untuk persetujuan admin.
     */
    public function process(Request $request)
    {
        // Pastikan user belum punya modul aktif sebelum memproses pembayaran baru
        // Sama seperti di atas, ini validasi ganda dari middleware.
        if (auth()->user()->hasActiveModule()) {
            return redirect()->route('dashboard')->with('info', 'Anda sudah memiliki modul aktif.');
        }

        // Validasi input dari form pembayaran
        $request->validate([
            // Pastikan 'yearly' juga ada di sini sesuai pilihan modul Anda
            'module_type' => 'required|in:lifetime,yearly', // <--- Pastikan 'yearly' ada di sini
            'payment_method' => 'required|string|max:50', // Batasi panjang string
        ]);

        // --- Logika untuk menghitung expiry_date berdasarkan module_type ---
        $expiryDate = null; // Default untuk modul 'lifetime'

        if ($request->module_type === 'yearly') { // <--- Cek jika tipe modul adalah 'yearly'
            $expiryDate = Carbon::now()->addYears(1); // <--- Atur kedaluwarsa 1 tahun dari sekarang
        }
        // Jika $request->module_type adalah 'lifetime', $expiryDate akan tetap null, sesuai keinginan.

        // --- Simpan data UserModule ke database ---
        UserModule::create([
            'user_id' => Auth::id(), // Gunakan Auth::id() lebih eksplisit
            'module_type' => $request->module_type,
            'expiry_date' => $expiryDate, // Gunakan variabel $expiryDate yang sudah dihitung
            'payment_method' => $request->payment_method,
            // Sesuaikan jumlah (amount) berdasarkan module_type
            'amount' => $request->module_type === 'lifetime' ? 500000 : 100000, // <--- Sesuaikan harga untuk 'yearly' jika berbeda dari 'monthly'
            'status' => 'inactive', // Status awal: inactive, karena masih menunggu persetujuan
            'status_approved' => 'pending', // Status persetujuan: pending
            'admin_notes' => null, // Catatan admin kosong di awal
        ]);

        // Redirect ke dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Modul Anda telah berhasil dipilih dan sedang menunggu persetujuan admin.');
    }
}