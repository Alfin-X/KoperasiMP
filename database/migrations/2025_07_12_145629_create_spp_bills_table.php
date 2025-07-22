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
        Schema::create('spp_bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // Anggota yang ditagih
            $table->string('bill_number')->unique(); // Nomor tagihan
            $table->integer('month'); // Bulan tagihan (1-12)
            $table->integer('year'); // Tahun tagihan
            $table->decimal('amount', 10, 2); // Nominal SPP
            $table->date('due_date'); // Tanggal jatuh tempo
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending');
            $table->timestamps();

            // Unique constraint untuk mencegah duplikasi tagihan per bulan
            $table->unique(['user_id', 'month', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spp_bills');
    }
};
