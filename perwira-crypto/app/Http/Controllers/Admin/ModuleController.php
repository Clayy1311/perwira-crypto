<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{


    // Menampilkan semua modul
    public function index()
    {
        $modules = Module::latest()->paginate(10);
        return view('admin.modules.index', compact('modules'));
    }

    // Form tambah modul
    public function create()
    {
        return view('admin.modules.create');
    }

    // Simpan modul baru
    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'type' => 'required|in:lifetime,monthly',
        'price' => 'required|numeric|min:0',
        'thumbnail' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($request->hasFile('thumbnail')) {
        $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        $validated['thumbnail'] = $thumbnailPath;
    }

    Module::create($validated);

    return redirect()->route('admin.modules.index')
        ->with('success', 'Modul berhasil ditambahkan!');
}


    // Form edit modul
    public function edit(Module $module)
    {
        return view('admin.modules.edit', compact('module'));
    }

    // Update modul
    public function update(Request $request, Module $module)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'type' => 'required|in:lifetime,monthly',
        'price' => 'required|numeric|min:0',
        'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($request->hasFile('thumbnail')) {
        $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        $validated['thumbnail'] = $thumbnailPath;
    }

    $module->update($validated);

    return redirect()->route('admin.modules.index')
        ->with('success', 'Modul berhasil diperbarui!');
}


    // Hapus modul
    public function destroy(Module $module)
    {
        $module->delete();
        return back()->with('success', 'Modul berhasil dihapus!');
    }
}