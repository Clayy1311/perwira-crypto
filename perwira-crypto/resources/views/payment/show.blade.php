<x-app-layout>
    {{-- Slot 'header' untuk judul halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Proses Pembayaran') }}
        </h2>
    </x-slot>

    {{-- Konten utama halaman --}}
    <div class="py-12"> {{-- Margin atas dan bawah --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> {{-- Lebar maksimum kontainer dan padding horizontal --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"> {{-- Latar belakang putih, bayangan, dan sudut membulat --}}
                <div class="p-6 text-gray-900"> {{-- Padding dan warna teks --}}

                    {{-- Pesan error dari session --}}
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Oops!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <h4 class="text-xl font-semibold mb-4">Modul: {{ $moduleType == 'lifetime' ? 'Lifetime Access' : '1 Month Access' }}</h4>
                    <h5 class="text-lg font-medium mb-6">Harga: Rp {{ number_format($moduleType == 'lifetime' ? 500000 : 100000, 0, ',', '.') }}</h5>

                    <form method="POST" action="{{ route('payment.process') }}">
                        @csrf
                        <input type="hidden" name="module_type" value="{{ $moduleType }}">

                        <div class="mb-4"> {{-- mb-3 di Bootstrap menjadi mb-4 di Tailwind untuk konsistensi --}}
                            <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                            <select class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm" id="payment_method" name="payment_method" required>
                                <option value="">Pilih metode...</option>
                                <option value="bank_transfer">Transfer Bank</option>
                                <option value="credit_card">Kartu Kredit</option>
                                <option value="e_wallet">E-Wallet (OVO/Gopay/Dana)</option>
                            </select>
                        </div>

                        <div class="mt-6"> {{-- d-grid gap-2 di Bootstrap menjadi mt-6 dan w-full untuk tombol --}}
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 w-full justify-center">
                                Lanjutkan Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>