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
        Schema::create('sppl', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_sppl');
            $table->string('nama');
            $table->string('noHp');
            $table->unsignedBigInteger('spt_id');
            $table->foreign('spt_id')->references('id')->on('surat_perintah_tugas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sppl');
    }
};
