# Sistem Pemesanan Gedung Aulia

Website pemesanan gedung yang menampilkan ketersediaan harian secara transparan, mendukung unggah bukti pembayaran, dan menyediakan panel admin untuk persetujuan serta laporan. Antarmuka responsif dengan fokus pada kemudahan pemesanan.

## Teknologi yang Digunakan
- Backend: Laravel 12 (Blade)
- Autentikasi: Laravel Breeze
- Frontend: Tailwind CSS 3, Vite 7, Alpine.js (untuk navbar mobile)
- PDF: barryvdh/laravel-dompdf
- Utilitas Tanggal: Carbon
- Database: MySQL (atau SQLite untuk pengembangan)

## Arsitektur Singkat
- Model inti: `User`, `Booking`, `Venue`
- Kontroler user: `BookingController` (buat/lihat/cetak)
- Panel admin: `Admin\BookingController` (daftar, filter, approve, reject, export CSV/PDF)
- Middleware role: `RoleMiddleware` memastikan hanya `role=admin` yang mengakses rute admin
- Tampilan utama: `home.blade.php` (hero + fitur + kalender ketersediaan)
- Navigasi responsif: `layouts/navigation.blade.php`

## Deskripsi Website
- Hero/Welcome: Judul besar “Gedung Serba Guna Aulia” dengan tombol “Pesan Sekarang” dan “Lihat Alamat”
- Section Fitur: poin singkat keunggulan gedung, tema hijau konsisten
- Kalender Ketersediaan:
  - Menandai tanggal dengan warna: tersedia, menunggu, disetujui
  - Guest dapat klik “Buat Pemesanan” → diarahkan login terlebih dahulu
  - Navigasi bulan: rentang hingga 12 bulan ke depan
- Halaman Pemesanan:
  - Form pemesanan: nama acara, tanggal mulai/selesai, jumlah tamu, deskripsi, unggah bukti (jpg/png/pdf, maks 5MB)
  - Validasi bentrok (overlap) agar tidak terjadi double-booking
- Panel Admin:
  - Approve/Tolak dengan catatan
  - Lihat/unduh bukti transfer
  - Export CSV/PDF untuk laporan

## Status Pemesanan (Label Indonesia)
- Menunggu (pending)
- Disetujui (approved)
- Ditolak (rejected)

## Persiapan & Instalasi

install tools yg dibutuhkan
- vscode
- laragon/xampp
- composer
- node js
- git

1. Clone
   ```bash
   git clone https://github.com/<username>/<repo>.git
   cd <repo>
   ```
2. Dependensi
   ```bash
   composer install
   npm install
   ```
3. Environment
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Database
   - MySQL: set `DB_CONNECTION=mysql`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
   - SQLite: set `DB_CONNECTION=sqlite` dan buat `database/database.sqlite`
5. Migrasi & Storage
   ```bash
   php artisan migrate
   php artisan storage:link
   ```
6. Seeder Admin
   ```bash
   php artisan db:seed --class=AdminUserSeeder
   ```
   - Admin: email `admin@aulia.test`, password `password123`
7. Build/Dev
   ```bash
   npm run build      # produksi
   npm run dev        # pengembangan (Vite)
   php artisan serve  # jalankan server
   ```

## Konfigurasi Venue
- Data harga, rekening, dan kontak admin berada di model `Venue` (lihat seeder `VenueSeeder`)
- Ubah melalui seed atau lewat panel admin (bisa ditambahkan sesuai kebutuhan)

## Penggunaan
- User:
  - Registrasi/login
  - Buka Home → cek kalender → klik “Buat Pemesanan”
  - Isi form dan unggah bukti transfer (opsional), status awal: Menunggu
- Admin:
  - Buka `/admin/bookings`
  - Filter Menunggu/Disetujui/Ditolak
  - Setujui/Tolak dengan catatan, unduh bukti, export laporan
- Cetak:
  - Di detail pemesanan user tersedia tombol “Cetak Bukti Reservasi”

## Laporan
- CSV:
  ```
  /admin/bookings/export/csv?start=YYYY-MM-DD&end=YYYY-MM-DD
  ```
- PDF:
  ```
  /admin/bookings/export/pdf?start=YYYY-MM-DD&end=YYYY-MM-DD
  ```

## Keamanan & Validasi
- Autentikasi terintegrasi (Breeze)
- Middleware `role:admin` untuk rute admin
- Validasi tanggal mulai/selesai dan cek bentrok (overlap)
- Upload file hanya tipe `jpg, jpeg, png, pdf` dan ukuran terbatas


## Lisensi
MIT
