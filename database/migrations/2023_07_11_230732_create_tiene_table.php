<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tiene', function (Blueprint $table) {
            $table->string('codigo_placa', 6)->primary();
            $table->string('codigo_numero_poliza', 15);

            $table->primary(['codigo_placa', 'codigo_numero_poliza']);

            $table->foreign('codigo_placa')
                ->references('placa')->on('vehiculo')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('codigo_numero_poliza')
                ->references('numero_poliza')->on('polizas')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tiene');
    }
};
