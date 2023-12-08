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
        Schema::create('Buses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')
            ->constrained('trips')
            ->cascadeOnDelete();
            $table->unsignedInteger('row_count');
            $table->unsignedInteger('left_row_count');
            $table->unsignedInteger('right_row_count');
            $table->unsignedInteger('last_row_count');
            $table->unsignedInteger('reserved_seats_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
