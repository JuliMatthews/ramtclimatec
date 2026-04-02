<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('direcciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
            $table->string('calle');
            $table->string('numero')->nullable();
            $table->string('depto')->nullable();
            $table->string('comuna');
            $table->string('ciudad')->default('Santiago');
            $table->string('region')->default('Metropolitana');
            $table->text('referencia')->nullable();
            $table->boolean('principal')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
};
