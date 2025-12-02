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
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();

            // Admin dueño del calendario (solo admin puede ver/usar esto)
            $table->unsignedBigInteger('admin_id')->nullable();

            // Día del calendario
            $table->date('date');

            // Horario general del día (opcional)
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            // Estado del día
            $table->string('status')->default('activo');

            $table->timestamps();

            // Llave foránea hacia admins
            $table->foreign('admin_id')
                ->references('id')
                ->on('admins')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendars');
    }
};
