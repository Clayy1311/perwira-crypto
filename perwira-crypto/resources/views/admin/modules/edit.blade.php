@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Modul</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops!</strong> Ada kesalahan pada input Anda.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('admin.modules.update', $module->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">Nama Modul</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $module->title) }}" required>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="4" required>{{ old('description', $module->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="type">Tipe</label>
                    <select name="type" class="form-control" required>
                        <option value="lifetime" {{ $module->type == 'lifetime' ? 'selected' : '' }}>Lifetime</option>
                        <option value="monthly" {{ $module->type == 'monthly' ? 'selected' : '' }}>Monthly</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="price">Harga (Rp)</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', $module->price) }}" required min="0">
                </div>

                 <div class="form-group">
                 <label for="thumbnail">Thumbnail</label>
                 <input type="file" name="thumbnail" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Update Modul</button>
                <a href="{{ route('admin.modules.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
