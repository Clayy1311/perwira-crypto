<x-app-layout>
    {{-- Header Halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Status Modul Anda') }}
        </h2>
    </x-slot>

    {{-- Konten Utama --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Pesan Peringatan --}}
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                        <strong class="font-bold">Modul Anda Telah Kedaluwarsa!</strong>
                        <span class="block sm:inline">Akses ke fitur-fitur premium tidak tersedia.</span>
                    </div>

                    <p class="mb-4">
                        Maaf, modul yang Anda pilih sebelumnya kini sudah tidak aktif karena telah melewati masa berlaku.
                        Anda tidak dapat lagi mengakses konten atau fitur terkait modul tersebut.
                    </p>

                    {{-- Menampilkan Tanggal Kedaluwarsa (Jika Ada) --}}
                    @php
                        // Coba ambil modul terakhir yang dimiliki user (bisa jadi yang sudah expired)
                        $latestModule = auth()->user()->modules()->latest()->first();
                    @endphp

                    @if ($latestModule && $latestModule->status_approved === 'approved' && $latestModule->expires_at && $latestModule->expires_at->isPast())
                        <p class="mt-2 text-sm text-gray-600 mb-4">
                            Modul Anda berakhir pada: <span class="font-semibold">{{ $latestModule->expires_at->format('d M Y') }}</span>
                        </p>
                    @elseif ($latestModule && $latestModule->status_approved === 'pending')
                         <p class="mt-2 text-sm text-gray-600 mb-4">
                            Modul Anda sedang menunggu persetujuan admin. Silakan tunggu konfirmasi.
                         </p>
                    @else
                         <p class="mt-2 text-sm text-gray-600 mb-4">
                            Anda belum memiliki modul aktif. Silakan pilih modul untuk memulai.
                         </p>
                    @endif


                    {{-- Tombol untuk Aksi --}}
                    <div class="mt-6 flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('select_module') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Pilih / Perpanjang Modul Sekarang
                        </a>
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded