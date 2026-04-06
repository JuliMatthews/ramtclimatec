<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('errors', function (Blueprint $table) {
            $table->id();
            $table->string('marca')->index();
            $table->string('tipo_equipo');
            $table->string('codigo_error')->index();
            $table->string('descripcion');
            $table->text('causa_probable');
            $table->text('solucion');
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('errors');
    }
};