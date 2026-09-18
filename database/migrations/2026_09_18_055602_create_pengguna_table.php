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
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id('id_pengguna');
            $table->string('username', 50)->unique();
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->string('nama_lengkap', 100);
            $table->string('telepon', 15)->nullable();
            $table->unsignedBigInteger('id_peran');
            $table->unsignedBigInteger('id_desa')->nullable();
            $table->foreign('id_peran')->references('id_peran')->on('peran');
            $table->foreign('id_desa')->references('id_desa')->on('desa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};
