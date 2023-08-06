<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Companies;

class EmpresasTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;
    private Companies $company;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        $this->company = Companies::factory()->create();
    }


    public function test_can_list_vehiculos()
    {
        Companies::factory()->count(5)->create();

        $this->get(route('empresas.index'))
            ->assertStatus(200);
    }

    /** @test */
    public function test_can_create_an_empresa()
    {
        $data = Companies::factory()->make()->toArray();

        $response = $this->postJson('/api/empresas', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas(Companies::class, $data);
    }

    /** @test */
    public function test_can_update_an_empresa()
    {
        $empresa = Companies::factory()->create([
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

        $response = $this->putJson(route('empresas.update', $empresa->id), $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas(Companies::class, $data);
    }

    /** @test */
    public function test_can_show_an_empresa()
    {
        $response = $this->getJson(route('empresas.show', $this->company->id));

        $response->assertStatus(200);
        $response->assertJson($this->company->toArray());
    }

    /** @test */
    public function test_can_delete_an_empresa()
    {
        $response = $this->deleteJson(route('empresas.destroy', $this->company->id));

        $response->assertStatus(204);
        $this->assertDatabaseMissing(Companies::class, $this->company->toArray());
    }
}
