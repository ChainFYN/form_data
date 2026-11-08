<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tim_lapangan', function (Blueprint $table) {
            $table->id('id_tim');
            $table->string('nama_tim', 50);
            $table->integer('jumlah_personel')->default(1);
            $table->enum('status', ['Tersedia', 'Di Lapangan', 'Standby'])->default('Tersedia');
            $table->unsignedBigInteger('id_kecamatan')->nullable();
            $table->foreign('id_kecamatan')->references('id_kecamatan')->on('kecamatan')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tim_lapangan');
    }
};
