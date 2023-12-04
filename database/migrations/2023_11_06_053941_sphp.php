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
        Schema::create('sphp', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('badan_usaha_id');
            $table->string('no_sphp')->unique();
            $table->date('tgl_sphp');
            $table->text('point_a');
            $table->text('point_b');
            $table->text('point_c');
            $table->foreign('badan_usaha_id')->references('id')->on('badan_usaha')->onDelete('cascade');
            $table->timestamps();

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sphp');
    }
};
