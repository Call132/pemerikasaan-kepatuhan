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
        Schema::create('extPendamping', function (Blueprint $table) {
            $table->id(); // Kolom primary key
            $table->string('nama');
            $table->string('jabatan')->default('Jabatan');
            $table->unsignedBigInteger('surat_perintah_tugas_id')->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('surat_perintah_tugas_id')->references('id')->on('surat_perintah_tugas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extPendamping');
    }
};
