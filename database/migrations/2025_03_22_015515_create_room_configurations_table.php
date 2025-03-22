<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('room_configurations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
        $table->integer('quantity');
        $table->enum('room_type', ['Estándar', 'Junior', 'Suite']);
        $table->enum('accommodation', ['Sencilla', 'Doble', 'Triple', 'Cuádruple']);
        $table->timestamps();

        // Impedir configuraciones duplicadas para el mismo hotel
        $table->unique(['hotel_id', 'room_type', 'accommodation']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_configurations');
    }
};
