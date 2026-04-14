<?php

namespace Database\Seeders;

use App\Models\Venue;
use Illuminate\Database\Seeder;

class VenueSeeder extends Seeder
{
    public function run(): void
    {
        Venue::updateOrCreate(
            ['nama' => 'Gedung Aulia'],
            [
                'harga_per_hari' => 2000000,
                'bank_rekening' => 'BCA 1234567890 a/n Gedung Aulia',
                'admin_phone' => '0812-3456-7890',
            ]
        );
    }
}
