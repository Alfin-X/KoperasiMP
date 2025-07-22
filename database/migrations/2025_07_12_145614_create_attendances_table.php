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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained(); // Jadwal latihan
            $table->foreignId('user_id')->constrained(); // Anggota yang diabsen
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpa']); // Status kehadiran
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->foreignId('recorded_by')->constrained('users'); // Pelatih yang mencatat
            $table->timestamps();

            // Unique constraint untuk mencegah duplikasi absensi
            $table->unique(['schedule_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
