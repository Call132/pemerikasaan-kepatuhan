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
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->nullable()->unique();
            $table->string('jenis_surat');
            $table->unsignedBigInteger('perencanaan_id');
            $table->unsignedBigInteger('badan_usaha_id');
            $table->date('tanggal_surat');
            $table->string('file_path')->nullable();
            $table->foreign('perencanaan_id')->references('id')->on('perencanaan')->onDelete('cascade');
            $table->foreign('badan_usaha_id')->references('id')->on('badan_usaha')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};
