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
                    <div class="mb-4">
                        {{ __("You're logged in!") }}
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <a href="{{ route('bookings.create') }}" class="block p-4 border rounded hover:border-primary">
                            <div class="font-semibold mb-1">Buat Pemesanan</div>
                            <div class="text-sm text-gray-600">Ajukan reservasi untuk acara Anda.</div>
                        </a>
                        <a href="{{ route('bookings.index') }}" class="block p-4 border rounded hover:border-primary">
                            <div class="font-semibold mb-1">Pemesanan Saya</div>
                            <div class="text-sm text-gray-600">Lihat status dan riwayat pemesanan.</div>
                        </a>
                        <a href="{{ route('home') }}" class="block p-4 border rounded hover:border-primary">
                            <div class="font-semibold mb-1">Kalender Ketersediaan</div>
                            <div class="text-sm text-gray-600">Cek tanggal/slot yang tersedia.</div>
                        </a>
                        @if(auth()->user()?->role === 'admin')
                            <a href="{{ route('admin.bookings.index') }}" class="block p-4 border rounded hover:border-primary">
                                <div class="font-semibold mb-1">Admin: Daftar Pemesanan</div>
                                <div class="text-sm text-gray-600">Kelola approve/reject dan laporan.</div>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
