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
            $table->foreignId('spp_bill_id')->constrained(); // Tagihan SPP
            $table->string('payment_method')->default('transfer'); // Metode pembayaran
            $table->decimal('amount', 10, 2); // Jumlah yang dibayar
            $table->string('proof_image')->nullable(); // Path file bukti pembayaran
            $table->text('notes')->nullable(); // Catatan pembayaran
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->foreignId('verified_by')->nullable()->constrained('users'); // Admin yang verifikasi
            $table->timestamp('verified_at')->nullable(); // Waktu verifikasi
            $table->text('rejection_reason')->nullable(); // Alasan penolakan
            $table->timestamps();
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
