<x-app-layout>
    {{-- Slot 'header' untuk judul halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Halaman Member') }}
        </h2>
    </x-slot>

    {{-- Konten utama halaman --}}
    <div class="py-12"> {{-- Margin atas dan bawah --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> {{-- Lebar maksimum kontainer dan padding horizontal --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"> {{-- Latar belakang putih, bayangan, dan sudut membulat --}}
                <div class="p-6 text-gray-900"> {{-- Padding dan warna teks --}}

                    {{-- Pesan status Approved Member --}}
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                        Status Anda: <strong class="font-bold">Approved Member</strong>
                    </div>
                    
                    <h4 class="text-2xl font-bold mb-4">Modul Anda:</h4>

                    {{-- Loop melalui modul yang disetujui --}}
                    @forelse(auth()->user()->modules()->where('status_approved','approved')->get() as $module)
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 shadow-sm mb-4">
                            <h5 class="text-xl font-semibold mb-2">
                                {{ $module->module_type === 'lifetime' ? 'Modul Lifetime' : 'Modul 1 Bulan' }}
                            </h5>
                            <p class="text-gray-700 text-sm mb-0">Disetujui pada: {{ $module->updated_at->format('d M Y') }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500 text-lg">Anda belum memiliki modul yang disetujui.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
