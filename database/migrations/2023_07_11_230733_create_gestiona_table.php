<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gestiona', function (Blueprint $table) {
            $table->bigIncrements('codigo_obra');
            $table->string('codigo_dni', 8);

            $table->foreign('codigo_obra')
                ->references('codigo_obra')->on('obra')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('codigo_dni')
                ->references('dni')->on('gestor')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('gestiona');
    }
};