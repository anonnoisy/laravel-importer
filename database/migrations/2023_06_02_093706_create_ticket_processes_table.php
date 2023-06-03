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
        Schema::create('ticket_processes', function (Blueprint $table) {
            $table->string('ticket_code');
            $table->enum('status', ['OPEN', 'REVIEW', 'TRANSFER', 'RESOLVED', 'CLOSED'])->index();
            $table->string('user_id')->index();
            $table->dateTime('update_date');
            $table->timestamps();

            $table->foreign('ticket_code')->references('code')->on('tickets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_processes');
    }
};
