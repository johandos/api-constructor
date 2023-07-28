<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('constructions', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_obra');
            $table->string('nombre_obra', 50);
            $table->string('direccion', 75);
            $table->string('ubicacion', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obra');
    }
};
