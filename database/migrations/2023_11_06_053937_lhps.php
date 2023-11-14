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
        Schema::create('lhps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('badan_usaha_id');
            $table->string('tgl_lhps');
            $table->string('jumlah_bulan_menunggak');
            $table->string('jumlah_pekerja');
            $table->string('tanggapan_bu');
            $table->string('rekomendasi_pemeriksa');
            $table->string('last_year_bulan');
            $table->string('last_year_nominal');
            $table->string('this_year_bulan');
            $table->string('this_year_nominal');
            $table->string('image')->nullable();
            $table->foreign('badan_usaha_id')->references('id')->on('badan_usaha')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lhps');
    }
};
