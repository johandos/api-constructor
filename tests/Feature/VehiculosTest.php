<?php

namespace Tests\Feature;

use App\Models\Companies;
use App\Models\User;
use App\Models\Vehicles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VehiculosTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_can_list_vehiculos()
    {
        Vehicles::factory()->count(5)->create();

        $this->get(route('vehiculos.index'))
            ->assertStatus(200);
    }

    public function test_can_list_vehicles_with_rol()
    {
        Vehicles::factory()->count(5)->create();

        $this->get(route('vehiculos.index'))
            ->assertStatus(200);
    }

    public function test_can_search_vehicles()
    {
        $empresa = Companies::factory()->create();
        Vehicles::factory()->create([
            'placa' => 'ABC123',
            'numero_bastidor' => '123456789',
            'fotografia_vehiculo' => 'foto1.jpg',
            'companies_id' => $empresa->id
        ]);

        Vehicles::factory()->create([
            'placa' => 'DEF456',
            'numero_bastidor' => '987654321',
            'fotografia_vehiculo' => 'foto2.jpg',
            'companies_id' => $empresa->id
        ]);

        $response = $this->getJson('/api/vehiculos_search?search=ABC123');

        $response->assertStatus(200);
        $response->assertJson([
            'placa' => 'ABC123',
            'numero_bastidor' => '123456789',
            'fotografia_vehiculo' => 'foto1.jpg',
            'companies_id' => $empresa->id
        ]);
        $response->assertJsonMissing([
            ['placa' => 'DEF456']
        ]);
    }

    public function test_can_create_vehiculo()
    {
        $empresa = Companies::factory()->create();

        $image = UploadedFile::fake()->image('vehiculo.png', 800, 600);

        $data = [
            'placa' => 'NPT486',
            'numero_bastidor' => 'GTE39070081060X',
            'fotografia_vehiculo' => $image,
            'companies_id' => $empresa->id,
        ];

        $response = $this->post(route('vehiculos.store'), $data);
        // Comprueba que el archivo se haya cargado en el disco 'public'.
        Storage::disk('public')->assertExists("vehiculos/{$image->hashName()}");
        $response->assertStatus(201);

        $data['fotografia_vehiculo'] = $image->hashName();
        $this->assertDatabaseHas(Vehicles::class, $data);
    }

    public function test_can_update_vehiculo()
    {
        $empresa = Companies::factory()->create();
        $vehiculo = Vehicles::factory()->create([
            'placa' => 'NPT486',
        ]);

        $image = UploadedFile::fake()->image('vehiculo.png', 800, 600);

        // Datos a actualizar
        $data = [
            'placa' => 'NPT400',
            'numero_bastidor' => 'GTE39070081060X',
            'fotografia_vehiculo' => $image,
            'companies_id' => $empresa->id,
        ];

        // Realizar la petición de actualización
        $response = $this->putJson(route('vehiculos.update', $vehiculo->id), $data);

        // Verificar que la petición fue exitosa
        $response->assertStatus(200);

        // Verificar que la póliza se actualizó en la base de datos
        $data['fotografia_vehiculo'] = $image->hashName();
        $this->assertDatabaseHas(Vehicles::class, $data);

        // Comprueba que el archivo se haya cargado en el disco 'public/polizas'.
        Storage::disk('public')->assertExists("vehiculos/{$image->hashName()}");
    }

    public function test_can_get_vehiculo()
    {
        $empresa = Companies::factory()->create();
        $image = UploadedFile::fake()->image('vehiculo.png', 800, 600);
        $vehiculo = Vehicles::factory()->create([
            'placa' => 'NPT400',
            'numero_bastidor' => 'GTE39070081060X',
            'fotografia_vehiculo' => $image->hashName(),
            'companies_id' => $empresa->id,
        ]);

        $response = $this->get(route('vehiculos.show', $vehiculo->id));

        $response->assertStatus(200)
            ->assertJson([
                'placa' => 'NPT400',
                'numero_bastidor' => 'GTE39070081060X',
                'fotografia_vehiculo' => $image->hashName(),
                'companies_id' => $empresa->id,
            ]);
    }


    public function test_can_delete_vehiculo()
    {
        $vehiculo = Vehicles::factory()->create();

        $response = $this->delete(route('vehiculos.destroy', $vehiculo->id));

        $response->assertStatus(204);
        $this->assertDatabaseMissing(Vehicles::class, ['placa' => $vehiculo->id]);
    }
}
