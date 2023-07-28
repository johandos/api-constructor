<?php

namespace Database\Factories;

use App\Models\Constructions;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Constructions>
 */
class ConstructionsFactory extends Factory
{
    protected $model = Constructions::class;

    public function definition(): array
    {
        return [
            'codigo_obra' => $this->faker->unique()->numerify('######'),
            'nombre_obra' => $this->faker->word,
            'direccion' => $this->faker->address,
            'ubicacion' => $this->faker->city,
        ];
    }
}
