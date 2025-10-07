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
        Schema::create('data_sakit_izin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');
            $table->enum('tipe', ['sakit', 'izin']);
            $table->text('alasan');
            $table->string('document_path')->nullable();
            $table->enum('status', ['pending', 'tervalidasi', 'dibatalkan'])->default('pending');
            $table->integer('durasi_hari');
            $table->foreignId('divalidasi_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('divalidasi_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_sakit_izin');
    }
};
