<?php

namespace Database\Factories;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehiculo>
 */
class VehiculoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $empresa = Empresa::factory()->create();
        $image = UploadedFile::fake()->image('avatar.png', 800, 600);


        return [
            'placa' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{3}'),
            'numero_bastidor' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{11}[A-Z]{1}'),
            'fotografia_vehiculo' => $image,
            'ruc_empresa' => $empresa->ruc
        ];
    }
}
