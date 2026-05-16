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
        Schema::create('perkembangan', function (Blueprint $table) {
            $table->id('id_perkembangan');
            $table->datetime('waktu')->useCurrent();
            $table->decimal('kelembapan_tanah', 5, 2)->nullable();
            $table->decimal('kelembapan_udara', 5, 2)->nullable();
            $table->decimal('suhu', 5, 2)->nullable();
            $table->text('gambar', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perkembangan');
    }
};
