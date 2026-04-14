<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Reservasi - Gedung Aulia</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
    </head>
<body class="bg-white text-gray-900">
    <div class="max-w-2xl mx-auto p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-primary">Bukti Reservasi Gedung Aulia</h1>
            <button onclick="window.print()" class="no-print px-4 py-2 bg-primary text-white rounded hover:bg-green-700">Print</button>
        </div>
        <div class="border rounded p-6 space-y-3">
            <div class="flex justify-between">
                <div>
                    <div class="text-gray-500">Nama Pemesan</div>
                    <div class="font-medium">{{ $booking->user->name }}</div>
                </div>
                <div>
                    <div class="text-gray-500">Tanggal Reservasi</div>
                    <div class="font-medium">{{ \Carbon\Carbon::parse($booking->created_at)->isoFormat('DD MMM Y') }}</div>
                </div>
            </div>
            <hr>
            <div><span class="text-gray-500">Nama Acara:</span> <span class="font-medium">{{ $booking->nama_acara }}</span></div>
            <div><span class="text-gray-500">Tanggal Mulai:</span> <span class="font-medium">{{ \Carbon\Carbon::parse($booking->tanggal)->isoFormat('DD MMM Y') }}</span></div>
            <div><span class="text-gray-500">Tanggal Selesai:</span> <span class="font-medium">{{ \Carbon\Carbon::parse($booking->tanggal_selesai)->isoFormat('DD MMM Y') }}</span></div>
            <div><span class="text-gray-500">Dipesan selama:</span> <span class="font-medium">{{ \Carbon\Carbon::parse($booking->tanggal)->diffInDays(\Carbon\Carbon::parse($booking->tanggal_selesai))+1 }} hari</span></div>
            <div><span class="text-gray-500">Jumlah Tamu:</span> <span class="font-medium">{{ $booking->jumlah_tamu }}</span></div>
            <div><span class="text-gray-500">Total harga yang dibayar:</span> <span class="font-medium">
                @php $days = \Carbon\Carbon::parse($booking->tanggal)->diffInDays(\Carbon\Carbon::parse($booking->tanggal_selesai))+1; @endphp
                Rp {{ number_format($booking->harga_per_hari * $days, 0, ',', '.') }}
            </span></div>
            <div><span class="text-gray-500">Rekening Pembayaran:</span> <span class="font-medium">{{ $booking->rekening }}</span></div>
            <div><span class="text-gray-500">Kontak Admin:</span> <span class="font-medium">{{ $booking->admin_phone }}</span></div>
            <div><span class="text-gray-500">Status:</span> <span class="font-medium">{{ ucfirst($booking->status) }}</span></div>
            @if($booking->admin_note)
                <div><span class="text-gray-500">Catatan Admin:</span> <span class="font-medium">{{ $booking->admin_note }}</span></div>
            @endif
        </div>
        <div class="mt-6 text-xs text-gray-600">
            Dokumen ini merupakan bukti reservasi. Harap dibawa saat verifikasi di lokasi.
        </div>
    </div>
</body>
</html>
