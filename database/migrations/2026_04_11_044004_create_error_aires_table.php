<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('error_aires', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable();
            $table->string('marca')->nullable();
            $table->text('error');
            $table->text('causa')->nullable();
            $table->text('solucion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('error_aires');
    }
};