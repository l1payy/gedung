<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pemesanan Saya</h2>
            <a href="{{ route('bookings.create') }}" class="px-4 py-2 bg-primary text-white rounded hover:bg-green-700">Buat Pemesanan</a>
        </div>
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
                                    <th class="py-2 px-3">Tanggal</th>
                                    <th class="py-2 px-3">Waktu</th>
                                    <th class="py-2 px-3">Tamu</th>
                                    <th class="py-2 px-3">Status</th>
                                    <th class="py-2 px-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bookings as $b)
                                    <tr class="border-b">
                                        <td class="py-2 px-3">{{ $b->nama_acara }}</td>
                                        <td class="py-2 px-3">{{ \Carbon\Carbon::parse($b->tanggal)->isoFormat('DD MMM Y') }}</td>
                                        <td class="py-2 px-3">{{ \Carbon\Carbon::parse($b->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($b->waktu_selesai)->format('H:i') }}</td>
                                        <td class="py-2 px-3">{{ $b->jumlah_tamu }}</td>
                                        <td class="py-2 px-3">
                                            @php $color = $b->status === 'approved' ? 'bg-green-100 text-primary' : ($b->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700'); @endphp
                                            <span class="px-2 py-1 rounded text-xs {{ $color }}">{{ ucfirst($b->status) }}</span>
                                        </td>
                                        <td class="py-2 px-3">
                                            <a href="{{ route('bookings.show', $b) }}" class="text-primary hover:underline">Detail</a>
                                            @if($b->status !== 'rejected')
                                                <span class="mx-1">•</span>
                                                <a href="{{ route('bookings.printable', $b) }}" class="text-gray-700 hover:underline">Cetak</a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-4 text-center text-gray-500">Belum ada pemesanan.</td>
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
