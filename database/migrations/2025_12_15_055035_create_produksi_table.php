<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produksi', function (Blueprint $table) {
            $table->id('id_produksi');

            // template / custom
            $table->enum('jenis', ['template', 'custom'])->default('template');

            // nullable karena kalau custom tidak pakai template
            $table->foreignId('id_template')
                ->nullable()
                ->constrained('template_losbak', 'id_template')
                ->nullOnDelete();

            $table->integer('jumlah_produksi')->default(1);
            $table->date('tanggal');
            $table->string('tipe')->nullable();
            $table->enum('status', ['proses', 'selesai'])->default('proses');
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produksi');
    }
};

