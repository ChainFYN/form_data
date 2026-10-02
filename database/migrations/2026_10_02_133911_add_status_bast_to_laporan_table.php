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
        Schema::table('laporan', function (Blueprint $table) {
            $table->string('status_bast', 50)->nullable()->after('tingkat_bahaya');
            $table->text('catatan_bast')->nullable()->after('status_bast');
            $table->timestamp('tgl_verifikasi_bast')->nullable()->after('catatan_bast');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->dropColumn(['status_bast', 'catatan_bast', 'tgl_verifikasi_bast']);
        });
    }
};
