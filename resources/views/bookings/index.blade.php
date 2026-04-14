<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pemesanan Saya</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="text-left border-b">
                                    <th class="py-2 px-3">Nama Acara</th>
                                    <th class="py-2 px-3">Mulai</th>
                                    <th class="py-2 px-3">Selesai</th>
                                    <th class="py-2 px-3">Dipesan selama</th>
                                    <th class="py-2 px-3">Total harga yang dibayar</th>
                                    <th class="py-2 px-3">Status</th>
                                    <th class="py-2 px-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bookings as $b)
                                    @php
                                        $durasi = \Carbon\Carbon::parse($b->tanggal)->diffInDays(\Carbon\Carbon::parse($b->tanggal_selesai)) + 1;
                                        $statusColor = $b->status === 'approved' ? 'bg-green-100 text-green-700' : ($b->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700');
                                    @endphp
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-2 px-3 font-medium">{{ $b->nama_acara }}</td>
                                        <td class="py-2 px-3">{{ \Carbon\Carbon::parse($b->tanggal)->isoFormat('DD MMM Y') }}</td>
                                        <td class="py-2 px-3">{{ \Carbon\Carbon::parse($b->tanggal_selesai)->isoFormat('DD MMM Y') }}</td>
                                        <td class="py-2 px-3">{{ $durasi }} hari</td>
                                        <td class="py-2 px-3 font-medium">Rp {{ number_format($b->harga_per_hari * $durasi, 0, ',', '.') }}</td>
                                        <td class="py-2 px-3"><span class="px-2 py-1 rounded text-xs {{ $statusColor }}">{{ $b->status_label }}</span></td>
                                        <td class="py-2 px-3 space-x-2">
                                            <a href="{{ route('bookings.show', $b) }}" class="text-primary hover:underline">Detail</a>
                                            @if($b->status !== 'rejected')
                                                <span>•</span>
                                                <a href="{{ route('bookings.printable', $b) }}" class="text-gray-700 hover:underline">Cetak</a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-4 text-center text-gray-500">Belum ada pemesanan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
