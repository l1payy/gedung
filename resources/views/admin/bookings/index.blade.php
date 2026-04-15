<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin: Daftar Pemesanan</h2>
            <div class="space-x-2">
                <a href="{{ route('admin.bookings.index') }}" class="px-3 py-1 rounded border {{ !$status ? 'bg-primary text-white' : '' }}">Semua</a>
                <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}" class="px-3 py-1 rounded border {{ $status === 'pending' ? 'bg-primary text-white' : '' }}">Menunggu</a>
                <a href="{{ route('admin.bookings.index', ['status' => 'approved']) }}" class="px-3 py-1 rounded border {{ $status === 'approved' ? 'bg-primary text-white' : '' }}">Disetujui</a>
                <a href="{{ route('admin.bookings.index', ['status' => 'rejected']) }}" class="px-3 py-1 rounded border {{ $status === 'rejected' ? 'bg-primary text-white' : '' }}">Ditolak</a>
            </div>
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
                                    <th class="py-2 px-3">Pemesan</th>
                                    <th class="py-2 px-3">Nama Acara</th>
                                    <th class="py-2 px-3">Kategori</th>
                                    <th class="py-2 px-3">Tanggal</th>
                                    <th class="py-2 px-3">Dipesan selama</th>
                                    <th class="py-2 px-3">Total harga yang dibayar</th>
                                    <th class="py-2 px-3">Status</th>
                                    <th class="py-2 px-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bookings as $b)
                                    <tr class="border-b">
                                        <td class="py-2 px-3">{{ $b->user->name }}</td>
                                        <td class="py-2 px-3">{{ $b->nama_acara }}</td>
                                        <td class="py-2 px-3">{{ $b->kategori_acara }}</td>
                                        <td class="py-2 px-3">
                                            @php
                                                $s = \Carbon\Carbon::parse($b->tanggal);
                                                $e = \Carbon\Carbon::parse($b->tanggal_selesai);
                                                $days = $s->diffInDays($e) + 1;
                                            @endphp
                                            {{ $s->isoFormat('DD MMM Y') }}
                                        </td>
                                        <td class="py-2 px-3">{{ $days }} hari</td>
                                        <td class="py-2 px-3 font-medium">Rp {{ number_format($b->harga_per_hari * $days, 0, ',', '.') }}</td>
                                        <td class="py-2 px-3">{{ $b->status_label }}</td>
                                        <td class="py-2 px-3 space-x-2">
                                            <a href="{{ route('admin.bookings.show', $b) }}" class="text-primary hover:underline">Detail</a>
                                            @if($b->bukti_path)
                                                <span>•</span>
                                                <a href="{{ route('admin.bookings.bukti', $b) }}" class="text-gray-700 hover:underline" target="_blank">Bukti</a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-4 text-center text-gray-500">Tidak ada data.</td>
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
