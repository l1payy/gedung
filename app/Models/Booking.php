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
        'waktu_mulai',
        'waktu_selesai',
        'jumlah_tamu',
        'deskripsi',
        'bukti_path',
        'status',
        'admin_note',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'waktu_mulai' => 'datetime:H:i',
            'waktu_selesai' => 'datetime:H:i',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOverlap($query, $tanggal, $mulai, $selesai)
    {
        return $query
            ->whereDate('tanggal', $tanggal)
            ->where(function ($q) {
                $q->where('status', 'approved')
                    ->orWhere('status', 'pending');
            })
            ->where('waktu_mulai', '<', $selesai)
            ->where('waktu_selesai', '>', $mulai);
    }
}
