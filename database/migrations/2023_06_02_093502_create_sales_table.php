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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 20)->index();
            $table->unsignedDecimal('weight_total', 5, 2);
            $table->unsignedDecimal('shipping_cost', 8, 2);
            $table->unsignedDecimal('total_price', 10, 2);
            $table->unsignedDecimal('total_purchase_price', 10, 2);
            $table->unsignedBigInteger('customer_id')->index();
            $table->text('shipping_address');
            $table->unsignedBigInteger('shipping_service_id');
            $table->string('shipping_type', 10);
            $table->dateTime('shipping_date')->index();
            $table->dateTime('transaction_date')->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
