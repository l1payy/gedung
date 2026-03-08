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
        return view('bookings.create', ['prefillDate' => $prefillDate]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_acara' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'waktu_mulai' => ['required', 'date_format:H:i'],
            'waktu_selesai' => ['required', 'date_format:H:i', 'after:waktu_mulai'],
            'jumlah_tamu' => ['required', 'integer', 'min:1'],
            'deskripsi' => ['nullable', 'string'],
            'bukti_transfer' => ['nullable', 'file', 'max:5120', 'mimes:jpg,jpeg,png,pdf'],
        ]);

        $tanggal = $data['tanggal'];
        $mulai = $data['waktu_mulai'];
        $selesai = $data['waktu_selesai'];

        $overlap = Booking::overlap($tanggal, $mulai, $selesai)->exists();
        if ($overlap) {
            return back()
                ->withErrors(['waktu_mulai' => 'Waktu sudah terisi'])
                ->withInput();
        }

        $path = null;
        if ($request->hasFile('bukti_transfer')) {
            $path = $request->file('bukti_transfer')->store('bookings', 'public');
        }

        Booking::create([
            'user_id' => Auth::id(),
            'nama_acara' => $data['nama_acara'],
            'tanggal' => $tanggal,
            'waktu_mulai' => $mulai,
            'waktu_selesai' => $selesai,
            'jumlah_tamu' => $data['jumlah_tamu'],
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
