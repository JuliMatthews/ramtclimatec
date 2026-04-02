<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('region')->nullable()->after('tipo');
            $table->string('provincia')->nullable()->after('region');
            $table->string('comuna')->nullable()->after('provincia');
        });

        Schema::table('tecnicos', function (Blueprint $table) {
            $table->string('region')->nullable()->after('email');
            $table->string('provincia')->nullable()->after('region');
            $table->string('comuna')->nullable()->after('provincia');
        });

        Schema::table('ayudantes', function (Blueprint $table) {
            $table->string('region')->nullable()->after('email');
            $table->string('provincia')->nullable()->after('region');
            $table->string('comuna')->nullable()->after('provincia');
        });
    }

    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn(['region', 'provincia', 'comuna']);
        });
        Schema::table('tecnicos', function (Blueprint $table) {
            $table->dropColumn(['region', 'provincia', 'comuna']);
        });
        Schema::table('ayudantes', function (Blueprint $table) {
            $table->dropColumn(['region', 'provincia', 'comuna']);
        });
    }
};
