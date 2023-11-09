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
        Schema::create('tim_pemeriksa', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('npp');
            // Kolom-kolom lainnya
            $table->unsignedBigInteger('surat_perintah_tugas_id'); // Ini adalah kolom kunci asing untuk menghubungkan ke SuratPerintahTugas.
            $table->timestamps();
            $table->foreign('surat_perintah_tugas_id')->references('id')->on('surat_perintah_tugas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tim_pemeriksa');
    }
};
