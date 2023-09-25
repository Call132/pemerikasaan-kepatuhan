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
        Schema::create('pendamping', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('tim_pemeriksa_id'); // Foreign key ke tim_pemeriksa
        $table->string('pendamping_nama');
        $table->string('pendamping_npp');
        // Atribut lainnya
        $table->timestamps();

        $table->foreign('tim_pemeriksa_id')
            ->references('id')
            ->on('tim_pemeriksa')
            ->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendamping');
    }
};
