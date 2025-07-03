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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama lokasi latihan
            $table->string('code')->unique(); // Kode lokasi (misal: JMB001, JMB002)
            $table->text('address');
            $table->string('phone')->nullable();
            $table->integer('capacity')->default(0); // Kapasitas maksimal
            $table->text('facilities')->nullable(); // Fasilitas yang tersedia
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
