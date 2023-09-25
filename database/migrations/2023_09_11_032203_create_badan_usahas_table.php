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
            $table->string('kode_badan_usaha')->unique();
            $table->string('alamat');
            $table->string('kota_kab');
            $table->string('jenis_ketidakpatuhan');
            $table->date('tanggal_terakhir_bayar');
            $table->decimal('jumlah_tunggakan', 10, 2);
            $table->string('jenis_pemeriksaan');
            $table->date('jadwal_pemeriksaan');
            $table->decimal('total', 10, 2)->nullable();
            $table->string('status')->default('Diajukan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('badan_usaha', function (Blueprint $table) {
        $table->dropColumn('status');
    });
        // Schema::dropIfExists('badan_usahas');
    }
};
