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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->unsignedBigInteger('id_pengguna');
            $table->unsignedBigInteger('id_jalan');
            $table->unsignedBigInteger('id_kategori');
            $table->unsignedBigInteger('id_status')->default(1);
            $table->text('deskripsi')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('url_foto', 255)->nullable();
            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
            $table->foreign('id_jalan')->references('id_jalan')->on('jalan');
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori_kerusakan');
            $table->foreign('id_status')->references('id_status')->on('status_laporan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
