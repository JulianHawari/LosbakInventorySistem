<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produksi_detail', function (Blueprint $table) {
            $table->id('id_detail');
            $table->foreignId('id_produksi')
                ->constrained('produksi', 'id_produksi')
                ->cascadeOnDelete();

            $table->foreignId('id_bahan')
                ->constrained('bahan_baku', 'id_bahan');

            $table->integer('jumlah_dipakai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produksi_detail');
    }
};

