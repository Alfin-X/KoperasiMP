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
        Schema::create('cooperative_savings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members');
            $table->string('transaction_number')->unique();
            $table->enum('type', ['deposit', 'withdrawal', 'interest', 'penalty']); // Setoran, Penarikan, Bunga, Denda
            $table->enum('category', ['pokok', 'wajib', 'sukarela']); // Simpanan pokok, wajib, sukarela
            $table->decimal('amount', 15, 2);
            $table->decimal('balance_before', 15, 2);
            $table->decimal('balance_after', 15, 2);
            $table->date('transaction_date');
            $table->text('description')->nullable();
            $table->foreignId('processed_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cooperative_savings');
    }
};
