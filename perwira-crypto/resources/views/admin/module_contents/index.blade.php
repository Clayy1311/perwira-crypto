@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Konten Modul: {{ $module->title }}</h1>
    <a href="{{ route('admin.module_contents.create', $module->id) }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Tambah Konten
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($contents->count())
    <div class="card shadow">
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Urutan</th>
                        <th>Judul</th>
                        <th>Tipe Konten</th>
                        <th>Durasi (menit)</th>
                        <th>URL</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contents as $content)
                    <tr>
                        <td>{{ $content->order }}</td>
                        <td>{{ $content->title }}</td>
                        <td>{{ ucfirst($content->content_type) }}</td>
                        <td>{{ $content->duration ?? '-' }}</td>
                        <td>
                            <a href="{{ $content->url }}" target="_blank" class="text-primary">
                                Lihat
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.module_contents.edit', [$module->id, $content->id]) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.module_contents.destroy', [$module->id, $content->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus konten ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $contents->links() }}
        </div>
    </div>
    @else
    <p>Belum ada konten untuk modul ini.</p>
    @endif
</div>
@endsection
