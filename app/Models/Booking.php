<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_acara',
        'tanggal',
        'tanggal_selesai',
        'waktu_mulai',
        'waktu_selesai',
        'jumlah_tamu',
        'harga_per_hari',
        'rekening',
        'admin_phone',
        'deskripsi',
        'bukti_path',
        'status',
        'admin_note',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'tanggal_selesai' => 'date',
            'waktu_mulai' => 'datetime:H:i',
            'waktu_selesai' => 'datetime:H:i',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOverlap($query, $startDate, $endDate = null)
    {
        $end = $endDate ?? $startDate;
        return $query->whereIn('status', ['approved', 'pending'])
            ->whereDate('tanggal', '<=', $end)
            ->whereDate('tanggal_selesai', '>=', $startDate);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'approved' => 'Disetujui',
            'pending' => 'Menunggu',
            'rejected' => 'Ditolak',
            default => $this->status,
        };
    }
}
