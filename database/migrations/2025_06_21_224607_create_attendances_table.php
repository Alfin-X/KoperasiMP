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
            $table->foreignId('member_id')->constrained('members');
            $table->foreignId('location_id')->constrained('locations');
            $table->foreignId('schedule_id')->nullable()->constrained('schedules');
            $table->foreignId('recorded_by')->constrained('users'); // Pelatih yang mencatat
            $table->date('attendance_date');
            $table->time('check_in_time')->nullable();
            $table->time('check_out_time')->nullable();
            $table->enum('status', ['present', 'absent', 'sick', 'permission'])->default('present');
            $table->text('notes')->nullable();
            $table->decimal('latitude', 10, 8)->nullable(); // Geolokasi check-in
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();

            $table->unique(['member_id', 'attendance_date', 'schedule_id']);
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
