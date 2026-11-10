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
            if (! Schema::hasColumn('laporan', 'id_tim')) {
                $table->unsignedBigInteger('id_tim')->nullable()->after('id_status');
                $table->foreign('id_tim')->references('id_tim')->on('tim_lapangan')->onDelete('set null');
            }
            if (! Schema::hasColumn('laporan', 'no_bast')) {
                $table->string('no_bast', 50)->nullable();
            }
            if (! Schema::hasColumn('laporan', 'status_bast')) {
                $table->string('status_bast', 20)->default('Menunggu');
            }
            if (! Schema::hasColumn('laporan', 'url_pdf_bast')) {
                $table->string('url_pdf_bast', 255)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            if (Schema::hasColumn('laporan', 'id_tim')) {
                $table->dropForeign(['id_tim']);
                $table->dropColumn('id_tim');
            }
            if (Schema::hasColumn('laporan', 'no_bast')) {
                $table->dropColumn('no_bast');
            }
            if (Schema::hasColumn('laporan', 'url_pdf_bast')) {
                $table->dropColumn('url_pdf_bast');
            }
        });
    }
};
