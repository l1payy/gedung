<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pemesanan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background: #e8f5e9; }
        h1 { color: #198754; }
    </style>
    </head>
<body>
    <h1>Laporan Pemesanan Gedung Aulia</h1>
    <p>Periode: {{ \Carbon\Carbon::parse($start)->isoFormat('DD MMM Y') }} - {{ \Carbon\Carbon::parse($end)->isoFormat('DD MMM Y') }}</p>
    <table>
        <thead>
            <tr>
                <th>Pemesan</th>
                <th>Email</th>
                <th>Nama Acara</th>
                <th>Tanggal</th>
                <th>Durasi</th>
                <th>Harga/Hari</th>
                <th>Tamu</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $b)
                <tr>
                    <td>{{ $b->user->name }}</td>
                    <td>{{ $b->user->email }}</td>
                    <td>{{ $b->nama_acara }}</td>
                    <td>{{ \Carbon\Carbon::parse($b->tanggal)->isoFormat('DD MMM Y') }}</td>
                    <td>1 hari</td>
                    <td>{{ number_format($b->harga_per_hari, 0, ',', '.') }}</td>
                    <td>{{ $b->jumlah_tamu }}</td>
                    <td>{{ $b->status_label }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
