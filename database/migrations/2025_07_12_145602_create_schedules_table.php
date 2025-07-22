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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kolat_id')->constrained(); // Kolat yang mengadakan latihan
            $table->date('date'); // Tanggal latihan
            $table->time('start_time'); // Jam mulai
            $table->time('end_time'); // Jam selesai
            $table->string('topic')->nullable(); // Topik/materi latihan
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->enum('status', ['scheduled', 'ongoing', 'completed', 'cancelled'])->default('scheduled');
            $table->foreignId('created_by')->constrained('users'); // Admin yang membuat jadwal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
