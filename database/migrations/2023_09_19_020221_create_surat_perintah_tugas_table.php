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
        Schema::create('surat_perintah_tugas', function (Blueprint $table) {
        $table->id('surat_perintah_tugas_id');
        $table->string('nomor_spt')->default('00_00');
        $table->date('tanggal_spt')->default(now());
        $table->unsignedBigInteger('tim_pemeriksa_id')->nullable();
        $table->unsignedBigInteger('pendamping_id')->nullable();
        $table->foreign('tim_pemeriksa_id')->references('id')->on('tim_pemeriksa');
        $table->foreign('pendamping_id')->references('id')->on('pendamping');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_perintah_tugas');
    }
};
