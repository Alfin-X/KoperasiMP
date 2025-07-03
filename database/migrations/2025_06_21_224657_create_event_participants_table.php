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
        Schema::create('event_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('members');
            $table->date('registration_date');
            $table->decimal('registration_fee_paid', 10, 2)->default(0);
            $table->enum('status', ['registered', 'confirmed', 'attended', 'absent', 'cancelled'])->default('registered');
            $table->text('notes')->nullable();
            $table->json('achievements')->nullable(); // Prestasi yang diraih (juara, dll)
            $table->foreignId('registered_by')->constrained('users');
            $table->timestamps();

            $table->unique(['event_id', 'member_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_participants');
    }
};
