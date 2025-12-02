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
       Schema::create('blocks', function (Blueprint $table) {
            $table->id();

            // Relación con el calendario
            $table->unsignedBigInteger('calendar_id');

            // Hora de inicio y fin del bloque
            $table->time('start_time');
            $table->time('end_time');

            // Si está disponible para citas
            $table->boolean('is_available')->default(true);

            $table->timestamps();

            $table->foreign('calendar_id')
                ->references('id')
                ->on('calendars')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blocks');
    }
};
