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
        Schema::create('kertas_kerja', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('badan_usaha_id');
            $table->string('npwp');
            $table->string('uraian');
            $table->string('tanggapan_bu');
            $table->string('ref_pekerja');
            $table->string('koreksi');
            $table->string('master_file');
            $table->string('ref_iuran');
            $table->string('total_pekerja');
            $table->string('jumlah_bulan_menunggak');
            $table->foreign('badan_usaha_id')->references('id')->on('badan_usaha')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kertas_kerja');
    }
};
