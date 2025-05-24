@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Modul</h1>
        <a href="{{ route('admin.modules.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Modul
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                             <th>Thumbnail</th>
                            <th>Nama Modul</th>
                            <th>Deskripsi</th> {{-- Kolom baru --}}
                            <th>Tipe</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                   <tbody>
    @foreach($modules as $module)
    <tr>
        <td>
            @if ($module->thumbnail)
                <img src="{{ asset('storage/' . $module->thumbnail) }}" alt="Thumbnail" width="80">
            @else
                <span class="text-muted">Tidak ada</span>
            @endif
        </td>
        <td>{{ $module->title }}</td>
        <td>{{ Str::limit($module->description, 100) }}</td>
        <td>{{ ucfirst($module->type) }}</td>
        <td>Rp {{ number_format($module->price, 0, ',', '.') }}</td>
        <td>
            <a href="{{ route('admin.modules.edit', $module->id) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-edit"></i>
            </a>
            <form action="{{ route('admin.modules.destroy', $module->id) }}" 
                  method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" 
                        onclick="return confirm('Hapus modul ini?')">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</tbody>
                </table>
            </div>
            {{ $modules->links() }}
        </div>
    </div>
</div>
@endsection
