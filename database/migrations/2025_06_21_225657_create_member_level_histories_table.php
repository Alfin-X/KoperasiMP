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
        Schema::create('member_level_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members');
            $table->foreignId('from_level_id')->nullable()->constrained('levels');
            $table->foreignId('to_level_id')->constrained('levels');
            $table->date('promotion_date');
            $table->text('exam_notes')->nullable();
            $table->decimal('exam_score', 5, 2)->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('recommended_by')->constrained('users'); // Pelatih yang merekomendasikan
            $table->foreignId('approved_by')->nullable()->constrained('users'); // Admin yang menyetujui
            $table->text('approval_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_level_histories');
    }
};
