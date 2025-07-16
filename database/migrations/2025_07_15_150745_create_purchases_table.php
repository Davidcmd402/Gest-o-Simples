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
        Schema::create('purchases', function (Blueprint $table) {
    $table->id();

    $table->foreignId('product_id')
          ->constrained('products')
          ->onDelete('cascade');

    $table->foreignId('supplier_id')
          ->nullable()
          ->constrained('suppliers') // <-- aqui é o ponto chave
          ->onDelete('set null');

    $table->unsignedInteger('quantity');
    $table->decimal('purchase_price', 10, 2);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};