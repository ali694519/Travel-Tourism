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
        Schema::create('seat_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')
            ->constrained('bookings')
            ->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('place_of_birth');
            $table->date('date_of_place');
            $table->string('national_id');
            $table->string('card_image_front');
            $table->string('card_image_back');
            $table->string('seat_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seat_infos');
    }
};
