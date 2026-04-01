<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
            $table->foreignId('direccion_id')->constrained('direcciones')->cascadeOnDelete();
            $table->string('ubicacion')->nullable();
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('numero_serie')->nullable();
            $table->string('tension_nominal')->nullable();
            $table->string('frecuencia')->nullable();
            $table->string('potencia_calefaccion')->nullable();
            $table->string('potencia_enfriamiento')->nullable();
            $table->string('capacidad_calefaccion_btu')->nullable();
            $table->string('capacidad_enfriamiento_btu')->nullable();
            $table->string('masa_refrigerante')->nullable();
            $table->string('tipo_refrigerante')->nullable();
            $table->string('presion_minima')->nullable();
            $table->string('presion_maxima')->nullable();
            $table->string('pais_fabricacion')->nullable();
            $table->string('fecha_fabricacion')->nullable();
            $table->date('ultima_mantencion')->nullable();
            $table->date('proxima_mantencion')->nullable();
            $table->text('observaciones')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};