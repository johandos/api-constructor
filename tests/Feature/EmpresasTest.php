<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Empresa;

class EmpresasTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $empresa;

    public function setUp(): void
    {
        parent::setUp();

        $this->empresa = Empresa::factory()->create();
    }

    /** @test */
    public function test_can_create_an_empresa()
    {
        $data = Empresa::factory()->make()->toArray();

        $response = $this->postJson('/api/empresas', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas(Empresa::class, $data);
    }

    /** @test */
    public function test_can_update_an_empresa()
    {
        $empresa = Empresa::factory()->create([
            'ruc' => '05648695724',
        ]);

        $data = [
            'ruc' => '05648690000',
            'razon_social' => 'RazonSocial',
            'direccion' => 'Avenida de andalucia',
            'contacto' => 'Prueba',
            'correo' => 'test@correo.com',
            'telefono' => '666056512',
        ];

        $response = $this->putJson(route('empresas.update', $empresa->ruc), $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas(Empresa::class, $data);
    }

    /** @test */
    public function test_can_show_an_empresa()
    {
        $response = $this->getJson("/api/empresas/{$this->empresa->id}");

        $response->assertStatus(200);
        $response->assertJson($this->empresa->toArray());
    }

    /** @test */
    public function test_can_delete_an_empresa()
    {
        $response = $this->deleteJson("/api/empresas/{$this->empresa->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing(Empresa::class, $this->empresa->toArray());
    }
}
