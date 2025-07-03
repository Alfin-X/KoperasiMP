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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['competition', 'training', 'seminar', 'ceremony', 'other']);
            $table->enum('scope', ['internal', 'external', 'inter_location']); // Internal, Eksternal, Antar Lokasi
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('venue');
            $table->text('venue_address')->nullable();
            $table->decimal('registration_fee', 10, 2)->default(0);
            $table->date('registration_deadline')->nullable();
            $table->integer('max_participants')->nullable();
            $table->json('target_levels')->nullable(); // Array ID tingkatan yang boleh ikut
            $table->json('target_locations')->nullable(); // Array ID lokasi yang boleh ikut
            $table->enum('status', ['draft', 'open', 'closed', 'ongoing', 'completed', 'cancelled'])->default('draft');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
