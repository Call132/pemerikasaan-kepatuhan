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
        Schema::create('bapket', function (Blueprint $table) {
            $table->id();
            $table->string('no_bapket')->unique();
            $table->date('tgl_bapket');
            $table->string('nama_pemberi_kerja');
            $table->string('jabatan');
            $table->string('sebab_menunggak');
            $table->unsignedBigInteger('badan_usaha_id');
            $table->unsignedBigInteger('surat_perintah_tugas_id');
            $table->foreign('badan_usaha_id')->references('id')->on('badan_usaha')->onDelete('cascade');
            $table->foreign('surat_perintah_tugas_id')->references('id')->on('surat_perintah_tugas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bapket');
    }
};
