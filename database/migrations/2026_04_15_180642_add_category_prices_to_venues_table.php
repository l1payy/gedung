<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('venues', function (Blueprint $table) {
            $table->unsignedBigInteger('harga_wisuda')->default(1500000)->after('harga_per_hari');
            $table->unsignedBigInteger('harga_nikah')->default(6500000)->after('harga_wisuda');
            $table->unsignedBigInteger('harga_seminar')->default(2000000)->after('harga_nikah');
        });
    }

    public function down(): void
    {
        Schema::table('venues', function (Blueprint $table) {
            $table->dropColumn(['harga_wisuda', 'harga_nikah', 'harga_seminar']);
        });
    }
};
