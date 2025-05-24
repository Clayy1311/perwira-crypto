<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserModule;
use Illuminate\Http\Request;
use Carbon\Carbon; // <--- PENTING: Tambahkan ini!

class ModuleApprovalController extends Controller
{
    public function index()
    {
        $pendingModules = UserModule::with('user')
            ->where('status_approved', 'pending')
            ->paginate(10);

        return view('admin.index', compact('pendingModules'));
    }

    public function approve(UserModule $module)
    {
        $expiryDate = null; // Default untuk lifetime
        if ($module->module_type === 'yearly') {
            // Menggunakan addYears(1) untuk durasi 1 tahun.
            // Tidak perlu ->endOfDay() jika expiry_date di DB adalah TIMESTAMP
            $expiryDate = Carbon::now()->addYears(1);
        }

        $module->update([
            'status_approved' => 'approved',
            'expiry_date' => $expiryDate, // <-- Ini sudah benar
        ]);

        $message = 'Modul disetujui.';
        if ($expiryDate) {
            $message .= ' Hingga: ' . $expiryDate->format('d M Y');
        } else {
            $message .= ' (Lifetime)';
        }

        return back()->with('success', $message);
    }

    public function reject(Request $request, UserModule $module)
    {
        $request->validate(['notes' => 'required|string|max:255']);

        $module->update([
            'status' => 'inactive', // Pastikan status ini sesuai dengan logika Anda
            'status_approved' => 'rejected',
            'admin_notes' => $request->notes
        ]);

        return back()->with('success', 'Modul berhasil ditolak');
    }
}