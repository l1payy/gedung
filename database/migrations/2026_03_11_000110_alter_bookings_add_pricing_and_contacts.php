<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('harga_per_hari')->default(0)->after('jumlah_tamu');
            $table->string('rekening')->nullable()->after('harga_per_hari');
            $table->string('admin_phone')->nullable()->after('rekening');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['harga_per_hari', 'rekening', 'admin_phone']);
        });
    }
};
