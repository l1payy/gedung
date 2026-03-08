<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingOverlapTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_create_overlapping_booking(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $tanggal = Carbon::now()->toDateString();
        Booking::create([
            'user_id' => $user->id,
            'nama_acara' => 'Acara 1',
            'tanggal' => $tanggal,
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '12:00',
            'jumlah_tamu' => 50,
            'status' => 'approved',
        ]);

        $this->actingAs($user)
            ->post(route('bookings.store'), [
                'nama_acara' => 'Acara 2',
                'tanggal' => $tanggal,
                'waktu_mulai' => '11:00',
                'waktu_selesai' => '13:00',
                'jumlah_tamu' => 30,
            ])
            ->assertSessionHasErrors('waktu_mulai')
            ->assertSessionHasInput(['nama_acara' => 'Acara 2']);
    }
}
