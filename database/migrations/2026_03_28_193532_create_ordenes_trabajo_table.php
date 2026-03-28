<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordenes_trabajo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
            $table->foreignId('direccion_id')->constrained('direcciones')->cascadeOnDelete();
            $table->enum('tipo_servicio', [
                'primera_visita',
                'instalacion',
                'mantencion',
                'reparacion',
                'diagnostico',
                'garantia',
            ])->default('primera_visita');
            $table->enum('estado', [
                'pendiente',
                'en_progreso',
                'completada',
                'cancelada',
            ])->default('pendiente');
            $table->text('descripcion')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_termino')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordenes_trabajo');
    }
};