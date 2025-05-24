<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\ModuleContent;
use Illuminate\Http\Request;

class ModuleContentController extends Controller
{
    // Tampilkan list konten dari modul tertentu
    public function index(Module $module)
    {
        // Ambil konten yang berelasi dengan modul, urut berdasarkan 'order'
        $contents = $module->contents()->orderBy('order')->paginate(10);

        return view('admin.module_contents.index', compact('module', 'contents'));
    }

    // Form tambah konten baru untuk modul tertentu
    public function create(Module $module)
    {
        return view('admin.module_contents.create', compact('module'));
    }

    // Simpan konten baru ke modul tertentu
    public function store(Request $request, Module $module)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content_type' => 'required|in:video,pdf,quiz',
            'url' => 'required|string',
            'duration' => 'nullable|integer|min:0',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['module_id'] = $module->id;

        ModuleContent::create($validated);

        return redirect()->route('admin.module_contents.index', $module->id)
                         ->with('success', 'Konten berhasil ditambahkan!');
    }

    // Form edit konten
    public function edit(Module $module, ModuleContent $content)
    {
        return view('admin.module_contents.edit', compact('module', 'content'));
    }

    // Update konten
    public function update(Request $request, Module $module, ModuleContent $content)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content_type' => 'required|in:video,pdf,quiz',
            'url' => 'required|string',
            'duration' => 'nullable|integer|min:0',
            'order' => 'nullable|integer|min:0',
        ]);

        $content->update($validated);

        return redirect()->route('admin.module_contents.index', $module->id)
                         ->with('success', 'Konten berhasil diperbarui!');
    }

    // Hapus konten
    public function destroy(Module $module, ModuleContent $content)
    {
        $content->delete();

        return redirect()->route('admin.module_contents.index', $module->id)
                         ->with('success', 'Konten berhasil dihapus!');
    }
}
