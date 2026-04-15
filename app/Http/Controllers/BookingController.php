<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->orderByDesc('tanggal')
            ->orderBy('waktu_mulai')
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $prefillDate = request()->query('tanggal');
        $venue = \App\Models\Venue::first();
        return view('bookings.create', ['prefillDate' => $prefillDate, 'venue' => $venue]);
    }

    public function store(Request $request)
    {
        $maxDate = now()->clone()->addYear()->toDateString();
        $minDate = now()->toDateString();
        $data = $request->validate([
            'nama_acara' => ['required', 'string', 'max:255'],
            'kategori_acara' => ['required', 'string', 'in:Wisuda,Nikah,Seminar'],
            'tanggal' => ['required', 'date', "after_or_equal:$minDate", "before_or_equal:$maxDate"],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal', "before_or_equal:$maxDate"],
            'jumlah_tamu' => ['required', 'integer', 'min:1'],
            'deskripsi' => ['nullable', 'string'],
            'bukti_transfer' => ['nullable', 'file', 'max:5120', 'mimes:jpg,jpeg,png,pdf'],
        ]);

        $tanggal = $data['tanggal'];
        $tanggalSelesai = $data['tanggal_selesai'];

        $overlap = Booking::overlap($tanggal, $tanggalSelesai)->exists();
        if ($overlap) {
            return back()
                ->withErrors(['tanggal' => 'Rentang tanggal bentrok dengan pemesanan lain'])
                ->withInput();
        }

        $path = null;
        if ($request->hasFile('bukti_transfer')) {
            $path = $request->file('bukti_transfer')->store('bookings', 'public');
        }

        $venue = \App\Models\Venue::first();

        // Tentukan harga berdasarkan kategori dari DB
        $hargaPerHari = match ($data['kategori_acara']) {
            'Wisuda' => $venue?->harga_wisuda ?? 1500000,
            'Nikah' => $venue?->harga_nikah ?? 6500000,
            'Seminar' => $venue?->harga_seminar ?? 2000000,
            default => 0,
        };

        $rekening = $venue?->bank_rekening ?? '';
        $adminPhone = $venue?->admin_phone ?? '';

        Booking::create([
            'user_id' => Auth::id(),
            'nama_acara' => $data['nama_acara'],
            'kategori_acara' => $data['kategori_acara'],
            'tanggal' => $tanggal,
            'tanggal_selesai' => $tanggalSelesai,
            'waktu_mulai' => '00:00',
            'waktu_selesai' => '23:59',
            'jumlah_tamu' => $data['jumlah_tamu'],
            'harga_per_hari' => $hargaPerHari,
            'rekening' => $rekening,
            'admin_phone' => $adminPhone,
            'deskripsi' => $data['deskripsi'] ?? null,
            'bukti_path' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('bookings.index')->with('status', 'Pemesanan berhasil dibuat, menunggu persetujuan.');
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('bookings.show', compact('booking'));
    }

    public function printable(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('bookings.printable', compact('booking'));
    }
}
