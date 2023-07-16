<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->string('dni', 8)->primary();
            $table->string('usuario', 12);
            $table->string('nombre', 75);
            $table->string('apellidos', 9);
            $table->string('email', 75);
            $table->string('contrasenia', 24);
            $table->date('fecha_nacimiento');
            $table->string('codigo_ruc', 11);

            $table->foreign('codigo_ruc')
                ->references('ruc')->on('empresa')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
