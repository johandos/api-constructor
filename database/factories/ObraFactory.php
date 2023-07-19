<?php

namespace Database\Factories;

use App\Models\Obra;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Obra>
 */
class ObraFactory extends Factory
{
    protected $model = Obra::class;

    public function definition(): array
    {
        return [
            'nombre_obra' => $this->faker->word,
            'direccion' => $this->faker->address,
            'ubicacion' => $this->faker->city,
        ];
    }
}
