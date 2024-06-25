<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
    public function test_login_success(): void
    {
        $user = User::factory()->create([
            'name' => 'test',
            'email' => 'login@example.com',
            'password' => Hash::make('password')
        ]);


        $response = $this->post('/api/login',[
            'email' => $user->email,
            'password' => 'password'
        ]);
        
        $data = $response->json();
        $response->assertStatus(200);
        assertArrayHasKey('user',$data);
    }

    public function test_register_user_success(): void
    {
        $response = $this->post('api/register', [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => '123Asd..'
        ]);

        $response->assertStatus(201);
        $userData = $response->json();
        assertTrue($userData['success']);
        assertArrayHasKey('message',$userData);
        assertTrue($userData['message'] == 'usuario creado con exito');
    }
}
