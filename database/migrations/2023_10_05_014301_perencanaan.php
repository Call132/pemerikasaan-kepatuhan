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
        Schema::create('perencanaan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir');
            $table->string('status')->default('Diajukan'); // Tambahkan kolom status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perencanaan');
    }
};
