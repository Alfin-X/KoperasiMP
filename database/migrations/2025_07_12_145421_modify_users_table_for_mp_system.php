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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email'); // Nomor telepon
            $table->string('member_id')->unique()->nullable()->after('phone'); // ID Anggota (untuk anggota)
            $table->string('tingkatan')->nullable()->after('member_id'); // Tingkatan sabuk
            $table->date('join_date')->nullable()->after('tingkatan'); // Tanggal bergabung
            $table->foreignId('role_id')->constrained()->after('join_date'); // Role: admin, pelatih, anggota
            $table->foreignId('kolat_id')->nullable()->constrained()->after('role_id'); // Kolat untuk anggota
            $table->boolean('is_active')->default(true)->after('kolat_id'); // Status aktif/non-aktif
            $table->text('address')->nullable()->after('is_active'); // Alamat lengkap
            $table->date('birth_date')->nullable()->after('address'); // Tanggal lahir
            $table->enum('gender', ['L', 'P'])->nullable()->after('birth_date'); // Jenis kelamin
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['kolat_id']);
            $table->dropColumn([
                'phone', 'member_id', 'tingkatan', 'join_date',
                'role_id', 'kolat_id', 'is_active', 'address',
                'birth_date', 'gender'
            ]);
        });
    }
};
