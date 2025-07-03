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
        Schema::create('cooperative_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number')->unique();
            $table->foreignId('member_id')->constrained('members');
            $table->foreignId('location_id')->constrained('locations');
            $table->enum('type', ['sale', 'purchase', 'return', 'adjustment']); // Penjualan, Pembelian, Retur, Penyesuaian
            $table->decimal('total_amount', 12, 2);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('final_amount', 12, 2);
            $table->enum('payment_method', ['cash', 'credit', 'savings_deduction']); // Tunai, Kredit, Potong Simpanan
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->date('transaction_date');
            $table->text('notes')->nullable();
            $table->foreignId('processed_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cooperative_transactions');
    }
};
