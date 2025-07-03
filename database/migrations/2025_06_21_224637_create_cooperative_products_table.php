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
        Schema::create('cooperative_products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Kode produk
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category'); // Kategori produk (seragam, perlengkapan, dll)
            $table->decimal('purchase_price', 10, 2); // Harga beli
            $table->decimal('selling_price', 10, 2); // Harga jual
            $table->integer('stock_quantity')->default(0);
            $table->integer('min_stock')->default(0); // Stok minimum
            $table->string('unit'); // Satuan (pcs, kg, dll)
            $table->string('image_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cooperative_products');
    }
};
