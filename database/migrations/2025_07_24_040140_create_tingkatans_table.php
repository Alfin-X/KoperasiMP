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
        Schema::create('tingkatans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama tingkatan (Calon Anggota, Dasar 1, dll)
            $table->string('code'); // Kode tingkatan (CA, D1, D2, dll)
            $table->integer('level'); // Level urutan tingkatan
            $table->text('description')->nullable(); // Deskripsi tingkatan
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tingkatans');
    }
};
