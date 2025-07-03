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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_number')->unique(); // Nomor anggota
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('location_id')->constrained('locations'); // Lokasi utama
            $table->foreignId('current_level_id')->constrained('levels');
            $table->date('join_date');
            $table->date('level_achieved_date'); // Tanggal mencapai tingkatan saat ini
            $table->enum('membership_type', ['regular', 'student', 'family'])->default('regular');
            $table->decimal('monthly_fee', 10, 2)->default(0); // SPP bulanan
            $table->enum('status', ['active', 'inactive', 'suspended', 'graduated'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
