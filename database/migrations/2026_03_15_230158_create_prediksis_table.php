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
        Schema::create('prediksi', function (Blueprint $table) {
            $table->id('id_prediksi');
            $table->unsignedBigInteger('id_perkembangan');
            $table->foreign('id_perkembangan')->references('id_perkembangan')->on('perkembangan')->onDelete('cascade');
            $table->string('decision', 30);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prediksi');
    }
};
