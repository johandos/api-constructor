<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asignado', function (Blueprint $table) {
            $table->string('codigo_placa', 6)->primary();
            $table->string('codigo_dni', 8);

            $table->primary(['codigo_placa', 'codigo_dni']);

            $table->foreign('codigo_placa')
                ->references('placa')->on('vehiculo')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('codigo_dni')
                ->references('dni')->on('conductor')
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
        Schema::dropIfExists('asignado');
    }

};
