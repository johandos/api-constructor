<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Conductor;
use App\Models\Companies;
use App\Models\Constructions;
use App\Models\Polices;
use App\Models\User;
use App\Models\Vehicles;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Companies::factory(5)->create();
        User::factory(10)->create();
        Vehicles::factory(10)->create();
        Polices::factory(10)->create();
        Constructions::factory(10)->create();
    }
}
