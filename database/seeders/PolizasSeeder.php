<?php

namespace Database\Seeders;

use App\Models\Polizas;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PolizasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Polizas::factory()
            ->count(5)
            ->create();
    }
}
