<?php

namespace Tests\Feature;

use App\Models\Obra;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ObraTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_vehiculos()
    {
        Obra::factory()->count(5)->create();

        $this->get(route('obras.index'))
            ->assertStatus(200);
    }

    public function test_can_create_obra()
    {
        $obraData = [
            'nombre_obra' => 'Obra Test',
            'direccion' => 'Dirección de prueba',
            'ubicacion' => 'Ubicación de prueba',
        ];

        $this->post(route('obras.store'), $obraData)
            ->assertStatus(201);

        $this->assertDatabaseHas(Obra::class, $obraData);
    }

    public function test_can_update_obra()
    {
        $obra = Obra::factory()->create();

        $updatedObraData = [
            'nombre_obra' => 'Obra Actualizada',
            'direccion' => 'Nueva Dirección',
            'ubicacion' => 'Nueva Ubicación',
        ];

        $this->put(route('obras.update', $obra->codigo_obra), $updatedObraData)
            ->assertStatus(200);

        $this->assertDatabaseHas(Obra::class, $updatedObraData);
    }

    public function test_can_show_obra()
    {
        $obra = Obra::factory()->create();

        $this->get(route('obras.show', $obra->codigo_obra))
            ->assertStatus(200);
    }

    /*public function test_can_delete_obra()
    {
        $obra = Obra::factory()->create();

        $this->delete(route('obras.destroy', $obra->codigo_obra))
            ->assertStatus(204);

        $this->assertSoftDeleted(Obra::class, ['id' => $obra->codigo_obra]);
    }*/
}
