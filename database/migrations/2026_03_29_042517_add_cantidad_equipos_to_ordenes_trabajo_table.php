<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ordenes_trabajo', function (Blueprint $table) {
            $table->integer('cantidad_equipos')->default(1)->after('tipo_servicio');
        });
    }

    public function down(): void
    {
        Schema::table('ordenes_trabajo', function (Blueprint $table) {
            $table->dropColumn('cantidad_equipos');
        });
    }
};
