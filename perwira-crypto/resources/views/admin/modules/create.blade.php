@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header">
            <h4 class="mb-0">{{ isset($module) ? 'Edit' : 'Tambah' }} Modul</h4>
        </div>
        <div class="card-body">
           <form action="{{ isset($module) ? route('admin.modules.update', $module->id) : route('admin.modules.store') }}" method="POST" enctype="multipart/form-data">

                @csrf
                @if(isset($module)) @method('PUT') @endif

                <div class="form-group">
                    <label>Judul Modul</label>
                    <input type="text" name="title" class="form-control" 
                           value="{{ $module->title ?? old('title') }}" required>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3" required>{{ $module->description ?? old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label>Tipe Modul</label>
                    <select name="type" class="form-control" required>
                        <option value="lifetime" {{ (isset($module) && $module->type == 'lifetime') ? 'selected' : '' }}>
                            Lifetime Access
                        </option>
                        <option value="monthly" {{ (isset($module) && $module->type == 'monthly') ? 'selected' : '' }}>
                            1 Month Access
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Harga (Rp)</label>
                    <input type="number" name="price" class="form-control" 
                           value="{{ $module->price ?? old('price') }}" min="0" required>
                </div>
                <div class="form-group">
    <label for="thumbnail">Thumbnail</label>
    <input type="file" name="thumbnail" class="form-control">
</div>

                <button type="submit" class="btn btn-primary">
                    {{ isset($module) ? 'Update' : 'Simpan' }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection