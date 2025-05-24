<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Status Pembayaran
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($is_approved)
                        <div class="alert alert-success">
                            <p>Modul Anda sudah aktif!</p>
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                Akses Dashboard
                            </a>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <p class="font-bold">Status: 
                                <span class="capitalize">{{ $payment->status_approved }}</span>
                            </p>
                            @if($payment->status_approved === 'pending')
                                <p class="mt-2">Modul Anda sedang menunggu persetujuan admin</p>
                            @else
                                <p class="mt-2">Catatan Admin: {{ $payment->admin_notes }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>