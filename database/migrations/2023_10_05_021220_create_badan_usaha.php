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
        Schema::create('badan_usaha', function (Blueprint $table) {
            $table->id();
            $table->string('nama_badan_usaha');
            $table->string('kode_badan_usaha');
            $table->string('alamat');
            $table->string('kota_kab');
            $table->string('jenis_ketidakpatuhan');
            $table->date('tanggal_terakhir_bayar');
            $table->decimal('jumlah_tunggakan', 14, 2);
            $table->string('jenis_pemeriksaan');
            $table->date('jadwal_pemeriksaan');
            $table->integer('jumlah_bulan_menunggak')->nullable();
            $table->date('tanggal_bayar')->nullable();
            $table->decimal('jumlah_bayar', 14, 2)->nullable();
            $table->string('hasil_pemeriksaan')->default('Belum Diperiksa');
            $table->string('npwp')->nullable();
            $table->unsignedBigInteger('perencanaan_id');
            $table->foreign('perencanaan_id')
                ->references('id')
                ->on('perencanaan')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('badan_usaha');
    }
};
