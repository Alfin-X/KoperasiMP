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
        Schema::create('savings_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // Anggota yang melakukan transaksi
            $table->enum('type', ['simpanan_pokok', 'simpanan_wajib', 'simpanan_sukarela']); // Jenis simpanan
            $table->decimal('amount', 10, 2); // Jumlah setoran
            $table->text('description')->nullable(); // Deskripsi transaksi
            $table->string('proof_image')->nullable(); // Bukti transfer
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->foreignId('recorded_by')->nullable()->constrained('users'); // Pelatih yang mencatat
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
        Schema::dropIfExists('savings_transactions');
    }
};
