<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserModule;
use Illuminate\Http\Request;

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
        $module->update([
            'status' => 'active',
            'status_approved' => 'approved',
            'admin_notes' => 'Disetujui pada '.now()->format('d M Y')
        ]);

        return back()->with('success', 'Modul berhasil disetujui');
    }

    public function reject(Request $request, UserModule $module)
    {
        $request->validate(['notes' => 'required|string|max:255']);

        $module->update([
            'status' => 'inactive',
            'status_approved' => 'rejected',
            'admin_notes' => $request->notes
        ]);

        return back()->with('success', 'Modul berhasil ditolak');
    }
}