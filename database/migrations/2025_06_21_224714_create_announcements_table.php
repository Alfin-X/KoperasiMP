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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->enum('type', ['general', 'urgent', 'event', 'schedule', 'payment'])->default('general');
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->json('target_roles')->nullable(); // Array role yang menjadi target
            $table->json('target_locations')->nullable(); // Array lokasi yang menjadi target
            $table->datetime('publish_at')->nullable(); // Jadwal publikasi
            $table->datetime('expire_at')->nullable(); // Tanggal kadaluarsa
            $table->boolean('is_published')->default(false);
            $table->boolean('send_notification')->default(true); // Kirim notifikasi atau tidak
            $table->string('attachment_path')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
