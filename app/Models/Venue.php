<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'harga_per_hari',
        'harga_wisuda',
        'harga_nikah',
        'harga_seminar',
        'bank_rekening',
        'admin_phone',
    ];
}
