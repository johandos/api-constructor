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
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ejecuta');
    }
};
