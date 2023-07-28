<?php

namespace Database\Factories;

use App\Models\Polices;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends Factory<Polices>
 */
class PolicesFactory extends Factory
{
    protected $model = Polices::class;

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
            'telefono_aseguradora' => $this->faker->numerify('6########'),
            'telefono_broker' => $this->faker->numerify('90#######'),
            'cronograma_pago' => $this->faker->word(),
            'poliza_adjunta' => $file,
            'tipo_poliza' => $this->faker->randomElement(['SOAT', 'VEHICULAR', 'SAT', 'TREC', 'RC']),
            'estado_poliza' => $this->faker->randomElement(['activo', 'inactivo'])
        ];
    }
}
