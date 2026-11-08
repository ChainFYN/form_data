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
            $table->unsignedBigInteger('id_tim')->nullable()->after('id_status');
            $table->string('no_bast', 50)->nullable()->after('id_tim');
            $table->string('status_bast', 20)->default('Menunggu')->after('no_bast');
            $table->string('url_pdf_bast', 255)->nullable()->after('status_bast');
            $table->foreign('id_tim')->references('id_tim')->on('tim_lapangan')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->dropForeign(['id_tim']);
            $table->dropColumn(['id_tim', 'no_bast', 'status_bast', 'url_pdf_bast']);
        });
    }
};
