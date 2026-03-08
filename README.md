# Sistem Pemesanan Gedung Aulia

Proyek Laravel + Breeze (Blade) untuk pemesanan satu gedung dengan validasi double-booking, upload bukti transfer, panel admin, laporan CSV/PDF, dan kalender ketersediaan yang responsif.

## Fitur
- Autentikasi (register, login, logout) dengan Breeze.
- Role: user dan admin (seeder admin tersedia).
- Pemesanan dengan field: nama_acara, tanggal, waktu_mulai, waktu_selesai, jumlah_tamu, deskripsi, upload bukti (jpg/png/pdf, maks 5MB).
- Status pemesanan: pending, approved, rejected.
- Validasi overlap waktu pada tanggal yang sama.
- Admin: list, filter, lihat bukti, approve/reject (dengan catatan), export CSV/PDF laporan.
- User: riwayat, detail, tampilan siap-cetak bukti reservasi.
- Penyimpanan file di storage/app/public/bookings + storage:link.
- Kalender ketersediaan: tampil jelas tanggal/slot terisi, navigasi 12 bulan ke depan, responsif.

## Requirements
- PHP 8.2+
- Composer
- Node.js 18+
- Database: MySQL atau SQLite

## Instalasi
1. Clone
   ```bash
   git clone https://github.com/<username>/<repo>.git
   cd <repo>
   ```
2. Install dependencies
   ```bash
   composer install
   npm install
   ```
3. Salin environment
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Konfigurasi database
   - MySQL: set DB_CONNECTION=mysql, DB_DATABASE=gedung (atau nama lain), DB_USERNAME, DB_PASSWORD di `.env`, lalu buat database.
   - SQLite: set DB_CONNECTION=sqlite dan buat `database/database.sqlite`.
5. Migrasi & storage link
   ```bash
   php artisan migrate
   php artisan storage:link
   ```
6. Seed admin
   ```bash
   php artisan db:seed --class=AdminUserSeeder
   ```
   - Admin: email `admin@aulia.test`, password `password123`
7. Build assets
   ```bash
   npm run build
   ```
8. Jalankan server
   ```bash
   php artisan serve
   ```
   Akses http://127.0.0.1:8000

## Penggunaan
- User biasa: register, lalu buat pemesanan via menu “Buat Pemesanan”.
- Kalender: halaman Home; navigasi bulan pakai tombol Sebelumnya/Berikutnya (maks 12 bulan ke depan; bulan sebelum saat ini diblok).
- Admin: masuk sebagai admin, kelola di `/admin/bookings` (approve/reject, unduh bukti, export).
- Printable: tombol “Cetak Bukti Reservasi” di detail booking user.

## Laporan
- CSV: `/admin/bookings/export/csv?start=YYYY-MM-DD&end=YYYY-MM-DD`
- PDF: `/admin/bookings/export/pdf?start=YYYY-MM-DD&end=YYYY-MM-DD`

## Testing
```bash
php artisan test --filter=BookingOverlapTest
```

## Catatan
- Jangan commit `.env`, `vendor`, `public/build`, `storage` tertentu; sudah diset di `.gitignore`.
- Pastikan `php artisan storage:link` setelah deploy agar link file publik aktif.

## Lisensi
MIT
