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
        Schema::create('import_loggers', function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->string('path');
            $table->text('logs')->nullable();
            $table->enum('status', ['START', 'ERROR', 'DONE']);
            $table->enum('type', ['BATCH', 'SALE', 'PRODUCT', 'TICKET']);
            $table->foreignId('import_by')->constrained('users', 'id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_loggers');
    }
};
