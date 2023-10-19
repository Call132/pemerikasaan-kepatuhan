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
            $table->string('nomor_sppk');
            $table->time('waktu');
            $table->string('tempat');
            $table->unsignedBigInteger('spt_id');
            $table->timestamps();
            $table->foreign('spt_id')->references('id')->on('surat_perintah_tugas')->onDelete('cascade');
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
