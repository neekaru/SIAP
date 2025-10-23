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
        Schema::table('data_absensi', function (Blueprint $table) {
            $table->enum('jenis', ['masuk', 'pulang', 'alpha'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_absensi', function (Blueprint $table) {
            $table->enum('jenis', ['masuk', 'pulang'])->change();
        });
    }
};
