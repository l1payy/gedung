<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Pemesanan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-3">
                    <div><span class="text-gray-500">Nama Acara:</span> <span class="font-medium">{{ $booking->nama_acara }}</span></div>
                    <div><span class="text-gray-500">Tanggal:</span>
                        <span class="font-medium">
                            @if($booking->tanggal->equalTo($booking->tanggal_selesai))
                                {{ $booking->tanggal->isoFormat('DD MMM Y') }}
                            @else
                                {{ $booking->tanggal->isoFormat('DD MMM Y') }} - {{ $booking->tanggal_selesai->isoFormat('DD MMM Y') }}
                            @endif
                        </span>
                    </div>
                    <div><span class="text-gray-500">Dipesan selama:</span>
                        <span class="font-medium">
                            @php
                                $s = \Carbon\Carbon::parse($booking->tanggal);
                                $e = \Carbon\Carbon::parse($booking->tanggal_selesai);
                                $days = $s->diffInDays($e) + 1;
                            @endphp
                            {{ $days }} hari
                        </span>
                    </div>
                    <div><span class="text-gray-500">Jumlah Tamu:</span> <span class="font-medium">{{ $booking->jumlah_tamu }}</span></div>
                    <div><span class="text-gray-500">Total harga yang dibayar:</span> <span class="font-medium">Rp {{ number_format($booking->harga_per_hari * $days, 0, ',', '.') }}</span></div>
                    <div><span class="text-gray-500">Nomor Rekening:</span> <span class="font-medium">{{ $booking->rekening }}</span></div>
                    <div><span class="text-gray-500">Nomor Admin:</span> <span class="font-medium">{{ $booking->admin_phone }}</span></div>
                    <div><span class="text-gray-500">Status:</span> <span class="font-medium">{{ $booking->status_label }}</span></div>
                    @if($booking->deskripsi)
                        <div><span class="text-gray-500">Deskripsi:</span> <span class="font-medium">{{ $booking->deskripsi }}</span></div>
                    @endif
                    @if($booking->bukti_path)
                        <div><span class="text-gray-500">Bukti Transfer:</span> <a class="text-primary hover:underline" href="{{ Storage::disk('public')->url($booking->bukti_path) }}" target="_blank">Lihat</a></div>
                    @endif
                    <div class="pt-4">
                        <a href="{{ route('bookings.printable', $booking) }}" class="px-4 py-2 bg-primary text-white rounded hover:bg-green-700">Cetak Bukti Reservasi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
