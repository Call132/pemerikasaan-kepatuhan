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
        Schema::create('sppl', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_sppl')->unique();
            $table->date('tanggal_surat');
            $table->string('nama');
            $table->string('noHp');
            $table->unsignedBigInteger('surat_perintah_tugas_id');
            $table->foreign('surat_perintah_tugas_id')->references('id')->on('surat_perintah_tugas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sppl');
    }
};
