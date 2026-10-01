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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->string('title');
            $table->string('road_name');
            $table->string('subdistrict')->default('Kecamatan jember');
            $table->string('village');
            $table->string('road_class')->default('Ruas Utama jember');
            $table->string('category')->default('Kerusakan Struktur Perkerasan Jalan Kabupaten');
            $table->enum('urgency', ['darurat', 'tinggi', 'sedang', 'normal'])->default('sedang');
            $table->enum('status', ['menunggu_validasi', 'diteruskan_pupr', 'ditolak', 'selesai', 'draf'])->default('menunggu_validasi');
            $table->dateTime('sla_deadline')->nullable();
            $table->string('sla_text')->nullable();
            $table->text('description');
            $table->decimal('latitude', 10, 7)->default(-6.489100);
            $table->decimal('longitude', 10, 7)->default(106.841900);
            $table->integer('gps_accuracy_m')->default(12);
            $table->string('reporter_name');
            $table->string('reporter_nik');
            $table->string('reporter_phone');
            $table->string('reporter_address');
            $table->integer('reporter_reputation')->default(90);
            $table->string('photo_path');
            $table->string('pupr_priority')->nullable();
            $table->string('technical_estimate')->nullable();
            $table->text('verifier_notes')->nullable();
            $table->string('verified_by_name')->nullable();
            $table->string('verified_by_nip')->nullable();
            $table->string('verified_by_title')->nullable();
            $table->dateTime('verified_at')->nullable();
            $table->enum('decision', ['acc', 'reject', 'draf'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
