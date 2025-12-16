<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('log_stok', function (Blueprint $table) {
            $table->id('id_log');
            $table->foreignId('id_bahan')
                ->constrained('bahan_baku', 'id_bahan');

            $table->enum('tipe', ['IN', 'OUT']);
            $table->integer('jumlah'); // selalu positif
            $table->string('keterangan');
            $table->date('tanggal');

            // referensi sumber log
            $table->string('ref_type')->nullable(); // produksi/restock
            $table->unsignedBigInteger('ref_id')->nullable();

            $table->integer('stok_setelah')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_stok');
    }
};

