@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Konten Modul: {{ $module->title }}</h1>

    <form action="{{ route('admin.module_contents.store', $module->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Judul Konten</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label>Tipe Konten</label>
            <select name="content_type" class="form-control" required>
                <option value="">-- Pilih tipe konten --</option>
                <option value="video" {{ old('content_type') == 'video' ? 'selected' : '' }}>Video</option>
                <option value="pdf" {{ old('content_type') == 'pdf' ? 'selected' : '' }}>PDF</option>
                <option value="quiz" {{ old('content_type') == 'quiz' ? 'selected' : '' }}>Quiz</option>
            </select>
            @error('content_type') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label>URL (Link video, PDF, atau quiz)</label>
            <input type="text" name="url" class="form-control" value="{{ old('url') }}" required>
            @error('url') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label>Durasi (menit) <small>(Opsional, khusus untuk video)</small></label>
            <input type="number" name="duration" class="form-control" value="{{ old('duration') }}" min="0">
            @error('duration') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label>Urutan Konten</label>
            <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}" min="0">
            @error('order') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan Konten</button>
        <a href="{{ route('admin.module_contents.index', $module->id) }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
