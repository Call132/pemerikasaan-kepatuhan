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
        Schema::create('program_pemeriksaan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('badan_usaha_id');
            $table->string('npwp');
            $table->string('aspek_tenaga_kerja');
            $table->string('aspek_iuran');
            $table->string('peraturan');
            $table->string('daftar_pekerja');
            $table->string('struktur_organisasi');
            $table->string('daftar_slip_gaji');
            $table->string('slip_gaji');
            $table->string('absensi');
            $table->foreign('badan_usaha_id')->references('id')->on('badan_usaha')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_pemeriksaan');
    }
};
