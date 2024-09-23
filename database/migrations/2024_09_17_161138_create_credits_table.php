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
        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'recipient_id')->constrained();
            $table->integer('amount');
            $table->tinyInteger('term_in_months');
            $table->unsignedBigInteger('number')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('serial_series')->nullable();
            $table->timestamps();
            $table->unique(['serial_series', 'serial_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credits');
    }
};
