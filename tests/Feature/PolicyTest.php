<?php

namespace Tests\Feature;

use App\Models\Polizas;
use App\Services\FileStorageStrategies\PolizasStorageStrategy;
use Database\Seeders\PolizasSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PolicyTest extends TestCase
{
    use WithFaker;

    public function test_can_create_policy()
    {
        // Finge el disco de almacenamiento para las subidas de archivos
        Storage::fake('public');
        // Crea un archivo falso
        $file = UploadedFile::fake()->create('document.pdf', 500, 'application/pdf');
        $data = [
            'numero_poliza' => 'NP-486275',
            'fecha_inicio' => '2023-01-01',
            'fecha_fin' => '2023-12-31',
            'aseguradora' => 'Insurer Company',
            'telefono_aseguradora' => '1234567890',
            'telefono_broker' => '0987654321',
            'cronograma_pago' => 'Monthly',
            'poliza_adjunta' => $file,
            'tipo_poliza' => 'SOAT',
            'estado_poliza' => 'activo',
        ];

        $response = $this->post('/api/polizas', $data);
        // Comprueba que el archivo se haya cargado en el disco 'public'.
        Storage::disk('public')->assertExists("polizas/{$file->hashName()}");
        $response->assertStatus(201);

        $data['poliza_adjunta'] = $file->hashName();
        $this->assertDatabaseHas(Polizas::class, $data);
    }

    public function test_poliza_creation_fails_with_invalid_data()
    {
        $data = [
            'numero_poliza' => 12345,
            'poliza_adjunta' => 'policy.pdf',
        ];

        // Realiza la petición a la ruta que llama al método store del controlador
        $response = $this->post(route('polizas.store'), $data);

        // Comprueba que los errores de validación específicos están presentes en la respuesta
        $response->assertJsonValidationErrors([
            "numero_poliza" => [
                "El campo número de póliza debe ser una cadena de texto."
            ],
            "poliza_adjunta" => [
                'El campo póliza adjunta debe ser un archivo de tipo: pdf.'
            ]
        ]);

        $response->assertStatus(422);
    }

    public function test_can_update_policy()
    {
        $poliza = Polizas::factory()->create([
            'numero_poliza' => 'NP-789605'
        ]);

        // Crear un archivo fake para la prueba
        Storage::fake('public');
        $file = UploadedFile::fake()->create('document.pdf', 500, 'application/pdf');

        // Datos a actualizar
        $data = [
            'numero_poliza' => 'NP-789605',
            'fecha_inicio' => '2023-01-01',
            'fecha_fin' => '2023-12-31',
            'aseguradora' => 'La Gran Aseguradora',
            'telefono_aseguradora' => '1234567890',
            'telefono_broker' => '0987654321',
            'cronograma_pago' => 'anual',
            'poliza_adjunta' => $file,
            'tipo_poliza' => 'SOAT',
            'estado_poliza' => 'activo'
        ];

        // Realizar la petición de actualización
        $response = $this->putJson(route('polizas.update', $poliza->numero_poliza), $data);

        // Verificar que la petición fue exitosa
        $response->assertStatus(200);

        // Verificar que la póliza se actualizó en la base de datos
        $data['poliza_adjunta'] = $file->hashName();
        $this->assertDatabaseHas('polizas', $data);

        // Comprueba que el archivo se haya cargado en el disco 'public/polizas'.
        Storage::disk('public')->assertExists("polizas/{$file->hashName()}");
    }

    public function test_can_get_policy()
    {
        $poliza = Polizas::factory()->create();

        $response = $this->get(route('polizas.show', $poliza->numero_poliza));

        $response->assertStatus(200)
            ->assertJson([
                'numero_poliza' => $poliza->numero_poliza,
                'fecha_inicio' => $poliza->fecha_inicio,
                'fecha_fin' => $poliza->fecha_fin,
                'aseguradora' => $poliza->aseguradora,
            ]);
    }

    public function test_can_delete_policy()
    {
        $poliza = Polizas::factory()->create();

        $response = $this->delete(route('polizas.destroy', $poliza->numero_poliza));

        $response->assertStatus(204);
        $this->assertDatabaseMissing(Polizas::class, ['numero_poliza' => $poliza->numero_poliza]);
    }
}
