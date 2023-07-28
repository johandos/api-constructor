<?php

namespace Tests\Feature;

use App\Models\Constructions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ObraTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_vehiculos()
    {
        Constructions::factory()->count(5)->create();

        $this->get(route('obras.index'))
            ->assertStatus(200);
    }

    public function test_can_create_obra()
    {
        $obraData = [
            'codigo_obra' => '10552',
            'nombre_obra' => 'Constructions Test',
            'direccion' => 'Dirección de prueba',
            'ubicacion' => 'Ubicación de prueba',
        ];

        $this->post(route('obras.store'), $obraData)
            ->assertStatus(201);

        $this->assertDatabaseHas(Constructions::class, $obraData);
    }

    public function test_can_update_obra()
    {
        $obra = Constructions::factory()->create();

        $updatedObraData = [
            'nombre_obra' => 'Constructions Actualizada',
            'direccion' => 'Nueva Dirección',
            'ubicacion' => 'Nueva Ubicación',
        ];

        $this->put(route('obras.update', $obra->id), $updatedObraData)
            ->assertStatus(200);

        $this->assertDatabaseHas(Constructions::class, $updatedObraData);
    }

    public function test_can_show_obra()
    {
        $obra = Constructions::factory()->create();

        $this->get(route('obras.show', $obra->id))
            ->assertStatus(200);
    }

    public function test_can_delete_obra()
    {
        $obra = Constructions::factory()->create();

        $this->delete(route('obras.destroy', $obra->id))
            ->assertStatus(204);
    }
}
