<?php

namespace Tests\Feature;

use App\Models\Empresa;
use App\Models\Polizas;
use App\Models\Vehiculo;
use App\Services\FileStorageStrategies\PolizasStorageStrategy;
use Database\Seeders\PolizasSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class VehiculosTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_list_vehiculos()
    {
        Vehiculo::factory()->count(5)->create();

        $this->get(route('vehiculos.index'))
            ->assertStatus(200);
    }

    public function test_can_create_vehiculo()
    {
        $empresa = Empresa::factory()->create();
        $image = UploadedFile::fake()->image('vehiculo.png', 800, 600);

        $data = [
            'placa' => 'NPT486',
            'numero_bastidor' => 'GTE39070081060X',
            'fotografia_vehiculo' => $image,
            'ruc_empresa' => $empresa->ruc,
        ];

        $response = $this->post(route('vehiculos.store'), $data);
        // Comprueba que el archivo se haya cargado en el disco 'public'.
        Storage::disk('public')->assertExists("vehiculos/{$image->hashName()}");
        $response->assertStatus(201);

        $data['fotografia_vehiculo'] = $image->hashName();
        $this->assertDatabaseHas(Vehiculo::class, $data);
    }

    public function test_can_update_vehiculo()
    {
        $empresa = Empresa::factory()->create();
        $vehiculo = Vehiculo::factory()->create([
            'placa' => 'NPT486',
        ]);

        $image = UploadedFile::fake()->image('vehiculo.png', 800, 600);

        // Datos a actualizar
        $data = [
            'placa' => 'NPT400',
            'numero_bastidor' => 'GTE39070081060X',
            'fotografia_vehiculo' => $image,
            'ruc_empresa' => $empresa->ruc,
        ];

        // Realizar la petición de actualización
        $response = $this->putJson(route('vehiculos.update', $vehiculo->placa), $data);

        // Verificar que la petición fue exitosa
        $response->assertStatus(200);

        // Verificar que la póliza se actualizó en la base de datos
        $data['fotografia_vehiculo'] = $image->hashName();
        $this->assertDatabaseHas('vehiculo', $data);

        // Comprueba que el archivo se haya cargado en el disco 'public/polizas'.
        Storage::disk('public')->assertExists("vehiculos/{$image->hashName()}");
    }

    public function test_can_get_vehiculo()
    {
        $empresa = Empresa::factory()->create();
        $image = UploadedFile::fake()->image('vehiculo.png', 800, 600);
        $vehiculo = Vehiculo::factory()->create([
            'placa' => 'NPT400',
            'numero_bastidor' => 'GTE39070081060X',
            'fotografia_vehiculo' => $image->hashName(),
            'ruc_empresa' => $empresa->ruc,
        ]);

        $response = $this->get(route('vehiculos.show', $vehiculo->placa));

        $response->assertStatus(200)
            ->assertJson([
                'placa' => 'NPT400',
                'numero_bastidor' => 'GTE39070081060X',
                'fotografia_vehiculo' => $image->hashName(),
                'ruc_empresa' => $empresa->ruc,
            ]);
    }

    // TODO: Revisar este destroy
    /*public function test_can_delete_vehiculo()
    {
        $vehiculo = Vehiculo::factory()->create();

        $response = $this->delete(route('vehiculos.destroy', $vehiculo->placa));

        $response->assertStatus(204);
        $this->assertDatabaseMissing(Vehiculo::class, ['placa' => $vehiculo->placa]);
    }*/
}
