<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pesado', function (Blueprint $table) {
            $table->string('codigo_placa', 6)->primary();
            $table->string('veh_pesado', 15);

            $table->foreign('codigo_placa')
                ->references('placa')->on('vehiculo')
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
        Schema::dropIfExists('pesado');
    }
};
