<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('polizas', function (Blueprint $table) {
            $table->string('numero_poliza', 15)->primary();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('aseguradora', 15);
            $table->string('telefono_aseguradora', 9);
            $table->string('telefono_broker', 9);
            $table->string('cronograma_pago', 50);
            $table->string('poliza_adjunta', 50);
            $table->enum('estado_poliza', ['activo', 'inactivo']);
            $table->enum('tipo_poliza', ['SOAT', 'VEHICULAR', 'SAT', 'TREC', 'RC']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('polizas');
    }
};
