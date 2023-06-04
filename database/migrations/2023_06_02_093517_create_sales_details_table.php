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
        Schema::create('sales_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales');
            $table->string('invoice_number', 20)->index();
            $table->foreignId('product_id')->constrained('products');
            $table->unsignedInteger('qty');
            $table->unsignedDecimal('weight', 8, 2);
            $table->unsignedDecimal('unit_price', 10, 2);
            $table->unsignedDecimal('discount', 2, 2);
            $table->unsignedDecimal('total_price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_details');
    }
};
