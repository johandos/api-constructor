<?php

namespace Tests\Feature;

use App\Http\Controllers\Api\Auth\AuthController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /**
     * Test user registration.
     *
     * @return void
     */
    public function testUserRegistration()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'dni' => '12345678',
            'usuario' => 'userTest',
            'apellidos' => 'Apellidos',
            'password' => 'password',
            'fecha_nacimiento' => '1990-01-01',
        ];

        $this->postJson('/api/auth/register', $userData)
            ->assertStatus(201)
            ->assertJson([
                'message' => 'Usuario registrado con éxito'
            ]);

        $this->assertDatabaseHas(User::class, [
            'email' => $userData['email']
        ]);
    }

    /**
     * Test user login.
     *
     * @return void
     */
    public function testUserLogin()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123')
        ]);

        $loginData = [
            'email' => $user->email,
            'password' => 'password123'
        ];

        $this->postJson('/api/auth/login', $loginData)
            ->assertStatus(201)
            ->assertJson([
                'message' => 'Usuario registrado con éxito'
            ]);
    }

    /**
     * Test user logout.
     *
     * @return void
     */
    public function test_logout_successfully()
    {
        Log::shouldReceive('error')->never();

        $userModelMock = $this->partialMock(User::class, function ($mock) {
            $mock->shouldReceive('tokens->delete');
        });

        $this->actingAs($userModelMock);

        $authController = new AuthController();

        $response = $authController->logout();

        $this->assertEquals(ResponseAlias::HTTP_OK, $response->getStatusCode());
        $this->assertObjectHasAttribute('message', json_decode($response->getContent()));
    }
}
