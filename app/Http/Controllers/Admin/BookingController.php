<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = Booking::query()->with('user')->orderByDesc('tanggal')->orderBy('waktu_mulai');
        if ($status) {
            $query->where('status', $status);
        }
        $bookings = $query->paginate(15);

        return view('admin.bookings.index', compact('bookings', 'status'));
    }

    public function show(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    public function downloadBukti(Booking $booking)
    {
        if (! $booking->bukti_path || ! Storage::disk('public')->exists($booking->bukti_path)) {
            abort(404);
        }

        return Storage::disk('public')->download($booking->bukti_path);
    }

    public function approve(Request $request, Booking $booking)
    {
        $request->validate([
            'admin_note' => ['nullable', 'string'],
        ]);

        // Double-check overlap before approving
        $overlap = Booking::overlap($booking->tanggal)
            ->where('id', '!=', $booking->id)
            ->exists();
        if ($overlap) {
            return back()->withErrors(['booking' => 'Waktu sudah terisi oleh pemesanan lain.'])->withInput();
        }

        $booking->update([
            'status' => 'approved',
            'admin_note' => $request->input('admin_note'),
        ]);

        return redirect()->route('admin.bookings.index', ['status' => 'approved'])->with('status', 'Booking disetujui.');
    }

    public function reject(Request $request, Booking $booking)
    {
        $request->validate([
            'admin_note' => ['nullable', 'string'],
        ]);

        $booking->update([
            'status' => 'rejected',
            'admin_note' => $request->input('admin_note'),
        ]);

        return redirect()->route('admin.bookings.index', ['status' => 'rejected'])->with('status', 'Booking ditolak.');
    }

    public function exportCsv(Request $request)
    {
        $data = $request->validate([
            'start' => ['required', 'date'],
            'end' => ['required', 'date', 'after_or_equal:start'],
        ]);
        $rows = Booking::whereBetween('tanggal', [$data['start'], $data['end']])
            ->orderBy('tanggal')->orderBy('waktu_mulai')->with('user')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="laporan_pemesanan.csv"',
        ];

        $callback = function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Nama Pemesan', 'Email', 'Nama Acara', 'Tanggal', 'Durasi', 'Harga/Hari', 'Tamu', 'Status']);
            foreach ($rows as $b) {
                fputcsv($out, [
                    $b->user->name,
                    $b->user->email,
                    $b->nama_acara,
                    $b->tanggal,
                    '1 hari',
                    $b->harga_per_hari,
                    $b->jumlah_tamu,
                    $b->status_label,
                ]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $data = $request->validate([
            'start' => ['required', 'date'],
            'end' => ['required', 'date', 'after_or_equal:start'],
        ]);
        $rows = Booking::whereBetween('tanggal', [$data['start'], $data['end']])
            ->orderBy('tanggal')->orderBy('waktu_mulai')->with('user')->get();

        $pdf = Pdf::loadView('admin.bookings.export_pdf', [
            'rows' => $rows,
            'start' => $data['start'],
            'end' => $data['end'],
        ]);

        return $pdf->download('laporan_pemesanan.pdf');
    }
}
