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
        Schema::create('ot_equipo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_trabajo_id')->constrained('ordenes_trabajo')->onDelete('cascade');
            $table->foreignId('equipo_id')->constrained('equipos')->onDelete('cascade');

            // Campos específicos de la intervención al equipo
            $table->text('trabajo_realizado')->nullable();
            $table->string('estado_final')->nullable(); // Ej: Operativo, Pendiente, Fuera de Servicio

            // Campos técnicos medidos en esta visita (opcionales pero muy útiles)
            $table->string('presion_alta')->nullable();
            $table->string('presion_baja')->nullable();
            $table->string('temperatura_salida')->nullable();
            $table->string('amperaje')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ot_equipo');
    }
};
