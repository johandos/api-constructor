<?php

namespace Database\Factories;

use App\Models\Polizas;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends Factory<Polizas>
 */
class PolizasFactory extends Factory
{
    protected $model = Polizas::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Crear un archivo ficticio
        $file = UploadedFile::fake()->create('document.pdf', 500, 'application/pdf');

        return [
            'numero_poliza' => $this->faker->unique()->numerify('NP-######'),
            'fecha_inicio' => $this->faker->date(),
            'fecha_fin' => $this->faker->date(),
            'aseguradora' => $this->faker->company(),
            'telefono_aseguradora' => $this->faker->phoneNumber(),
            'telefono_broker' => $this->faker->phoneNumber(),
            'cronograma_pago' => $this->faker->word(),
            'poliza_adjunta' => $file,
            'tipo_poliza' => $this->faker->randomElement(['SOAT', 'VEHICULAR', 'SAT', 'TREC', 'RC']),
            'estado_poliza' => $this->faker->randomElement(['activo', 'inactivo'])
        ];
    }
}
