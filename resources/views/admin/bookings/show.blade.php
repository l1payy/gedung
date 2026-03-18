<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin: Detail Pemesanan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-3">
                    <div><span class="text-gray-500">Pemesan:</span> <span class="font-medium">{{ $booking->user->name }} ({{ $booking->user->email }})</span></div>
                    <div><span class="text-gray-500">Nama Acara:</span> <span class="font-medium">{{ $booking->nama_acara }}</span></div>
                    <div><span class="text-gray-500">Tanggal:</span> <span class="font-medium">{{ \Carbon\Carbon::parse($booking->tanggal)->isoFormat('DD MMM Y') }}</span></div>
                    <div><span class="text-gray-500">Durasi:</span> <span class="font-medium">1 hari</span></div>
                    <div><span class="text-gray-500">Jumlah Tamu:</span> <span class="font-medium">{{ $booking->jumlah_tamu }}</span></div>
                    <div><span class="text-gray-500">Harga per Hari:</span> <span class="font-medium">Rp {{ number_format($booking->harga_per_hari, 0, ',', '.') }}</span></div>
                    <div><span class="text-gray-500">Nomor Rekening:</span> <span class="font-medium">{{ $booking->rekening }}</span></div>
                    <div><span class="text-gray-500">Nomor Admin:</span> <span class="font-medium">{{ $booking->admin_phone }}</span></div>
                    <div><span class="text-gray-500">Status:</span> <span class="font-medium">{{ $booking->status_label }}</span></div>
                    @if($booking->deskripsi)
                        <div><span class="text-gray-500">Deskripsi:</span> <span class="font-medium">{{ $booking->deskripsi }}</span></div>
                    @endif
                    @if($booking->bukti_path)
                        <div><span class="text-gray-500">Bukti Transfer:</span> <a class="text-primary hover:underline" href="{{ route('admin.bookings.bukti', $booking) }}" target="_blank">Unduh/Lihat</a></div>
                    @endif

                    <form method="POST" action="{{ route('admin.bookings.approve', $booking) }}" class="space-y-2">
                        @csrf
                        <x-input-label value="Catatan Admin (opsional)" />
                        <textarea name="admin_note" class="mt-1 block w-full rounded border-gray-300">{{ old('admin_note', $booking->admin_note) }}</textarea>
                        <div class="flex gap-2 mt-2">
                            <button type="submit" class="px-4 py-2 bg-primary text-white rounded hover:bg-green-700">Setujui</button>
                            <button formaction="{{ route('admin.bookings.reject', $booking) }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Tolak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
