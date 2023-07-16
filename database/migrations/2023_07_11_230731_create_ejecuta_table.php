<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ejecuta', function (Blueprint $table) {
            $table->bigInteger('codigo_obra')->primary();
            $table->string('codigo_ruc', 11);

            $table->primary(['codigo_obra', 'codigo_ruc']);

            $table->foreign('codigo_obra')
                ->references('codigo_obra')->on('obra')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('codigo_ruc')
                ->references('ruc')->on('empresa')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ejecuta');
    }
};
