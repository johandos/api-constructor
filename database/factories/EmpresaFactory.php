<?php

namespace Database\Factories;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmpresaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Empresa::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ruc' => $this->faker->numerify('###########'), // genera un número de 11 dígitos
            'razon_social' => $this->faker->company,
            'direccion' => $this->faker->address,
            'contacto' => $this->faker->name,
            'correo' => $this->faker->unique()->safeEmail,
            'telefono' => $this->faker->numerify('#########'), // genera un número de 9 dígitos
        ];
    }
}
