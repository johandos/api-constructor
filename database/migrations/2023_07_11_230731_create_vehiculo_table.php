<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehiculo', function (Blueprint $table) {
            $table->string('placa', 6)->primary();
            $table->string('numero_bastidor', 15);
            $table->string('fotografia_vehiculo', 50);
            $table->string('ruc_empresa', 11);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculo');
    }
};
