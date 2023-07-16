<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('ruc', 11);
            $table->string('razon_social', 75);
            $table->string('direccion', 75);
            $table->string('contacto', 50);
            $table->string('correo', 50);
            $table->string('telefono', 9);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('empresa');
    }
};
