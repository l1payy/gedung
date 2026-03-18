<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->date('tanggal_selesai')->nullable()->after('tanggal');
        });

        DB::table('bookings')->update([
            'tanggal_selesai' => DB::raw('tanggal'),
        ]);

        Schema::table('bookings', function (Blueprint $table) {
            $table->date('tanggal_selesai')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('tanggal_selesai');
        });
    }
};
