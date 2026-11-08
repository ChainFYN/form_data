<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('log_proses', function (Blueprint $table) {
            $table->unsignedBigInteger('id_tim')->nullable()->after('id_pengguna');
            $table->foreign('id_tim')->references('id_tim')->on('tim_lapangan')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('log_proses', function (Blueprint $table) {
            $table->dropForeign(['id_tim']);
            $table->dropColumn('id_tim');
        });
    }
};
