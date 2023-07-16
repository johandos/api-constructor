<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('obra', function (Blueprint $table) {
            $table->bigIncrements('codigo_obra');
            $table->string('nombre_obra', 50);
            $table->string('direccion', 75);
            $table->string('ubicacion', 50);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obra');
    }
};
