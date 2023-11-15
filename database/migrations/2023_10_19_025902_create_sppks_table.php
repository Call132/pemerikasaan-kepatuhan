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
        Schema::create('sppk', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_sppk')->unique();
            $table->date('tanggal_surat');
            $table->time('waktu');
            $table->unsignedBigInteger('badan_usaha_id');
            $table->unsignedBigInteger('surat_perintah_tugas_id');
            $table->timestamps();
            $table->foreign('badan_usaha_id')->references('id')->on('badan_usaha')->onDelete('cascade');
            $table->foreign('surat_perintah_tugas_id')->references('id')->on('surat_perintah_tugas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sppk');
    }
};
