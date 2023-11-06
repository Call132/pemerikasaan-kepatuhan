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
            $table->unsignedBigInteger('badan_usaha_id');
            $table->string('no_bapket');
            $table->date('tgl_bapket');
            $table->string('nama_pemberi_kerja');
            $table->string('jabatan');
            $table->string('sebab_menunggak');
            $table->foreign('badan_usaha_id')->references('id')->on('badan_usaha')->onDelete('cascade');
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
