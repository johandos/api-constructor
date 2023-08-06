<?php

namespace Database\Seeders;

use App\Models\Companies;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'id' => 1
        ]);
        User::factory()->create([
            'id' => 2
        ]);
        User::factory()->create([
            'id' => 3
        ]);
    }
}
