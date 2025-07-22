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
        Schema::create('savings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // Anggota pemilik simpanan
            $table->decimal('simpanan_pokok', 10, 2)->default(0); // Simpanan Pokok (Rp 50.000)
            $table->decimal('simpanan_wajib', 10, 2)->default(0); // Simpanan Wajib (Rp 3.000/hari)
            $table->decimal('simpanan_sukarela', 10, 2)->default(0); // Simpanan Sukarela
            $table->decimal('total_balance', 10, 2)->default(0); // Total saldo
            $table->boolean('simpanan_pokok_paid')->default(false); // Status pembayaran simpanan pokok
            $table->timestamps();

            // Unique constraint untuk satu anggota satu record simpanan
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('savings');
    }
};
