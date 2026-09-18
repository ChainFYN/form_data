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
        Schema::create('log_proses', function (Blueprint $table) {
            $table->id('id_log');
            $table->unsignedBigInteger('id_laporan');
            $table->unsignedBigInteger('id_pengguna');
            $table->unsignedBigInteger('id_status');
            $table->text('catatan_update')->nullable();
            $table->string('url_foto_selesai', 255)->nullable();
            $table->foreign('id_laporan')->references('id_laporan')->on('laporan')->onDelete('cascade');
            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna');
            $table->foreign('id_status')->references('id_status')->on('status_laporan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_proses');
    }
};
