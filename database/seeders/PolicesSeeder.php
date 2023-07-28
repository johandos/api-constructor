<?php

namespace Database\Seeders;

use App\Models\Polices;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PolicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Polices::factory()
            ->count(5)
            ->create();
    }
}
