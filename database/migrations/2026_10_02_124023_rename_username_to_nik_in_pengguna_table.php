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
        Schema::table('pengguna', function (Blueprint $table) {
            $table->renameColumn('username', 'nik');
        });

        Schema::table('pengguna', function (Blueprint $table) {
            $table->string('nik', 16)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
            $table->renameColumn('nik', 'username');
        });

        Schema::table('pengguna', function (Blueprint $table) {
            $table->string('username', 50)->change();
        });
    }
};
