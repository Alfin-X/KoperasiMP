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
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama tingkatan (Putih, Kuning, Hijau, dll)
            $table->string('color'); // Warna sabuk
            $table->integer('order')->unique(); // Urutan tingkatan (1, 2, 3, dst)
            $table->text('requirements')->nullable(); // Syarat untuk mencapai tingkatan ini
            $table->integer('min_training_hours')->default(0); // Minimal jam latihan
            $table->integer('min_months')->default(0); // Minimal bulan di tingkatan sebelumnya
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};
