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
        Schema::create('cooperative_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members');
            $table->string('loan_number')->unique();
            $table->decimal('loan_amount', 15, 2);
            $table->decimal('interest_rate', 5, 2)->default(0); // Annual interest rate in percentage
            $table->integer('loan_term_months'); // Loan term in months
            $table->decimal('monthly_payment', 15, 2);
            $table->decimal('total_amount', 15, 2); // Total amount to be paid (principal + interest)
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->decimal('remaining_amount', 15, 2);
            $table->date('loan_date');
            $table->date('due_date');
            $table->enum('status', ['active', 'paid', 'overdue', 'cancelled'])->default('active');
            $table->text('purpose')->nullable(); // Purpose of loan
            $table->text('notes')->nullable();
            $table->foreignId('approved_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cooperative_loans');
    }
};
