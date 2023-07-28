<?php

namespace Database\Factories;

use App\Models\Companies;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicles>
 */
class VehiclesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $empresa = Companies::factory()->create();
        $image = UploadedFile::fake()->image('vehicle.png', 800, 600);


        return [
            'placa' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{3}'),
            'numero_bastidor' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{11}[A-Z]{1}'),
            'fotografia_vehiculo' => $image,
            'companies_id' => $empresa->id
        ];
    }
}
