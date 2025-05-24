@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Modul Anda</h2>
    
    @if($modules->isEmpty())
        <div class="alert alert-info">
            Tidak ada modul yang tersedia
        </div>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Modul</th>
                    <th>Tipe</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($modules as $module)
                <tr>
                    <td>{{ $module->title }}</td>
                    <td>{{ ucfirst($module->type) }}</td>
                    <td>
                        <a href="{{ route('modules.show', $module->id) }}" class="btn btn-info">
                            Lihat
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection