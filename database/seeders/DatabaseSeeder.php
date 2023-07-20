<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Conductor;
use App\Models\Empresa;
use App\Models\Obra;
use App\Models\Polizas;
use App\Models\User;
use App\Models\Vehiculo;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Empresa::factory(5)->create();
        User::factory(10)->create();
        Vehiculo::factory(10)->create();
        Polizas::factory(10)->create();
        Obra::factory(10)->create();
    }
}
