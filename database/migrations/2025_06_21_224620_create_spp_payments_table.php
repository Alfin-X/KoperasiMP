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
        Schema::create('spp_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members');
            $table->string('invoice_number')->unique();
            $table->year('payment_year');
            $table->tinyInteger('payment_month'); // 1-12
            $table->decimal('base_amount', 10, 2); // Nominal SPP dasar
            $table->decimal('penalty_amount', 10, 2)->default(0); // Denda keterlambatan
            $table->decimal('discount_amount', 10, 2)->default(0); // Diskon
            $table->decimal('total_amount', 10, 2); // Total yang harus dibayar
            $table->decimal('paid_amount', 10, 2)->default(0); // Yang sudah dibayar
            $table->date('due_date'); // Tanggal jatuh tempo
            $table->date('paid_date')->nullable(); // Tanggal pembayaran
            $table->enum('status', ['pending', 'paid', 'overdue', 'cancelled'])->default('pending');
            $table->enum('payment_method', ['cash', 'transfer', 'other'])->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users');
            $table->timestamps();

            $table->unique(['member_id', 'payment_year', 'payment_month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spp_payments');
    }
};
