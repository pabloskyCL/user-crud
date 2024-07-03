<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

use function PHPUnit\Framework\assertArrayHasKey;
use function PHPUnit\Framework\assertTrue;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testLoginSuccess(): void
    {
        $user = User::factory()->create([
            'name' => 'test',
            'email' => 'login@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $data = $response->json();
        $response->assertStatus(200);
        assertArrayHasKey('user', $data);
    }

    public function testRegisterUserSuccess(): void
    {
        $response = $this->post('api/register', [
            'name' => 'test register',
            'email' => 'prueba@registro.com',
            'password' => '5Dwagost.',
        ]);

        $response->assertStatus(201);
        $userData = $response->json();
        assertTrue($userData['success']);
        assertArrayHasKey('message', $userData);
        assertTrue('usuario creado con exito' == $userData['message']);
    }
}
