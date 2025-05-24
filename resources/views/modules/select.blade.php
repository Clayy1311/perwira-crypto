<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Pilih Modul Belajar
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-2">Modul Lifetime</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Rp 500.000</p>
                        <a href="{{ route('payment.show', 'lifetime') }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                            Pilih Modul Ini
                        </a>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-2">Modul 1 Tahun</h3> {{-- <--- Ubah teks di sini --}}
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Rp 100.000</p> {{-- <--- Sesuaikan harga jika beda --}}
                        <a href="{{ route('payment.show', 'yearly') }}" {{-- <--- Ubah parameter menjadi 'yearly' --}}
                           class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition ease-in-out duration-150">
                            Pilih Modul Ini
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <div class="text-center py-4 text-gray-500 dark:text-gray-400 text-sm">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </x-slot>
</x-app-layout>