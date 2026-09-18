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
        Schema::create('validasi', function (Blueprint $table) {
            $table->id('id_validasi');
            $table->unsignedBigInteger('id_laporan');
            $table->unsignedBigInteger('id_pengguna');
            $table->enum('status_valid', ['VALID', 'TIDAK_VALID']);
            $table->text('catatan')->nullable();
            $table->foreign('id_laporan')->references('id_laporan')->on('laporan')->onDelete('cascade');
            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validasi');
    }
};
