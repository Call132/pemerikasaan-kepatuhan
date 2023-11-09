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
        Schema::create('sppfpk', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_sppfpk')->unique();
            $table->date('tanggal_surat');
            $table->time('waktu');
            $table->unsignedBigInteger('sppk_id');
            $table->timestamps();
            $table->foreign('sppk_id')->references('id')->on('sppk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sppfpk');
    }
};
