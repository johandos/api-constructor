<?php

namespace Tests\Feature;

use App\Models\Empresa;
use App\Models\Polizas;
use App\Models\User;
use App\Services\FileStorageStrategies\PolizasStorageStrategy;
use Database\Seeders\PolizasSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class UsuariosTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_list_vehiculos()
    {
        User::factory()->count(5)->create();

        $this->get(route('usuarios.index'))
            ->assertStatus(200);
    }

    public function test_can_create_usuario()
    {
        $empresa = Empresa::factory()->create();

        $userData = [
            'dni' => '12345678',
            'usuario' => 'userTest',
            'name' => 'Nombre Test',
            'apellidos' => 'Apellidos',
            'email' => 'email@test.com',
            'password' => 'passwordTest',
            'fecha_nacimiento' => '1990-01-01',
            'codigo_ruc' => $empresa->ruc,
        ];

        $this->post(route('usuarios.store'), $userData)
            ->assertStatus(201);
    }

    public function test_can_update_usuario()
    {
        $empresa = Empresa::factory()->create();
        $user = User::factory()->create();

        $updatedUsuarioData = [
            'dni' => '12300678',
            'usuario' => 'userTest',
            'name' => 'Nombre Test',
            'apellidos' => 'Apellidos',
            'email' => 'email@test.com',
            'password' => 'passwordTest',
            'fecha_nacimiento' => '1990-01-01',
            'codigo_ruc' => $empresa->ruc,
        ];

        $this->put(route('usuarios.update', $user->id), $updatedUsuarioData)
            ->assertStatus(200);
    }

    public function test_can_show_usuario()
    {
        $user = User::factory()->create();

        $this->get(route('usuarios.show', $user->id))
            ->assertStatus(200);
    }

    /*public function test_can_delete_usuario()
    {
        $user = User::factory()->create();

        $this->delete(route('usuarios.destroy', $user->codigo_usuario))
            ->assertStatus(204);

        $this->assertSoftDeleted(User::class, ['id' => $user->codigo_usuario]);
    }*/
}
