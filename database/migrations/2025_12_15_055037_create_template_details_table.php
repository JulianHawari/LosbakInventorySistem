<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('template_detail', function (Blueprint $table) {
            $table->id('id_detail');
            $table->foreignId('id_template')
                ->constrained('template_losbak', 'id_template')
                ->cascadeOnDelete();

            $table->foreignId('id_bahan')
                ->constrained('bahan_baku', 'id_bahan');

            $table->integer('jumlah'); // kebutuhan per 1 produksi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_detail');
    }
};
