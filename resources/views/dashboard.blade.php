<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(isset($activeModule) && $activeModule)
                        {{-- Konten untuk user DENGAN MODUL AKTIF (APPROVED) --}}
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Selamat!</strong>
                            <span class="block sm:inline">Modul Anda ({{ $activeModule->module_type === 'lifetime' ? 'Lifetime' : '1 Bulan' }}) telah aktif dan siap digunakan.</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-4">Detail Modul Anda:</h3>
                        <p>Nama Modul: {{ $activeModule->module ? $activeModule->module->name : 'N/A' }}</p>
                        <p>Jenis: {{ $activeModule->module_type }}</p>
                        {{-- Tambahkan detail modul aktif lainnya di sini --}}

                    @elseif(isset($pendingModule) && $pendingModule)
                        {{-- Konten untuk user DENGAN MODUL PENDING --}}
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-6" role="alert">
                            <strong class="font-bold">Perhatian!</strong>
                            <span class="block sm:inline">Modul Anda telah berhasil dipilih dan **sedang menunggu persetujuan dari admin**.</span>
                            <p class="mt-2 text-sm">Anda telah memilih modul: <span class="font-bold">{{ $pendingModule->module ? $pendingModule->module->name : 'N/A' }} ({{ $pendingModule->module_type === 'lifetime' ? 'Lifetime' : 'Bulanan' }})</span>.</p>
                            <p class="mt-2 text-sm">Mohon tunggu kabar dari kami. Anda akan menerima notifikasi setelah modul Anda disetujui.</p>
                        </div>
                        <h4 class="text-xl font-semibold mb-4">Detail Modul Menunggu Persetujuan:</h4>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 shadow-sm">
                            <p class="mb-1">Nama Modul: <span class="font-medium">{{ $pendingModule->module ? $pendingModule->module->name : 'N/A' }}</span></p>
                            <p class="mb-1">Jenis Durasi: <span class="font-medium">{{ $pendingModule->module_type === 'lifetime' ? 'Lifetime' : '1 Bulan' }}</span></p>
                            <p class="mb-1">Tanggal Dipilih: <span class="font-medium">{{ $pendingModule->created_at->format('d M Y H:i') }}</span></p>
                            <p class="mb-0">Status Persetujuan: <span class="font-bold text-yellow-600">Menunggu Persetujuan</span></p>
                        </div>

                    @elseif(isset($noModule) && $noModule)
                        {{-- Konten untuk user BELUM MEMILIH MODUL --}}
                        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                            Anda belum memilih modul apapun.
                        </div>
                        <p class="mb-4">Silakan pilih modul untuk memulai:</p>
                        <a href="{{ route('select_module') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Pilih Modul Sekarang</a>
                    @else
                        {{-- Fallback jika ada status lain yang tidak tercover (misalnya user baru register) --}}
                        <p class="mb-4">Selamat datang di dashboard Anda!</p>
                        <p>Silakan pilih modul untuk memulai pengalaman belajar Anda.</p>
                        <a href="{{ route('select_module') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Pilih Modul Sekarang</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>