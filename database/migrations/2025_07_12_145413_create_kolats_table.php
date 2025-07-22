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
        Schema::create('kolats', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Kolat
            $table->text('address'); // Alamat tempat latihan
            $table->string('schedule_day'); // Hari latihan (Senin, Selasa, dll)
            $table->time('schedule_time'); // Jam latihan
            $table->text('description')->nullable(); // Deskripsi tambahan
            $table->boolean('is_active')->default(true); // Status aktif/non-aktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kolats');
    }
};
