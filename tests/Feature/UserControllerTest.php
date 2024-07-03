<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testShowUserSuccess()
    {
        $user = User::factory()->create([
            'name' => 'showUser',
            'email' => 'show@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->syncRoles(['Admin']);
        $response = $this->actingAs($user)->get('/api/user/'.$user->id);
        $response->assertStatus(200);
        $data = $response->json();

        $this->assertEquals([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $user->roles->pluck('name')->toArray(),
            'created_at' => $user->created_at->__toString(),
        ], $data['data']);
    }

    public function testDeleteUserWithRoleUserTest()
    {
        $user = User::factory()->create([
            'name' => 'deleteFailUser',
            'email' => 'deleteFail@example.com',
            'password' => Hash::make('password'),
        ]);

        $user->syncRoles(['User']);

        $response = $this->actingAs($user)->delete('/api/user', [
            'id' => 1,
        ]);

        $response->assertStatus(403);
    }

    public function testDeleteUserSuccess()
    {
        $user = User::factory()->create([
            'name' => 'deleteUser',
            'email' => 'delete@example.com',
            'password' => Hash::make('password'),
        ]);

        $user->syncRoles(['Admin']);

        $response = $this->actingAs($user)->delete('/api/user', [
            'id' => 1,
        ]);

        $response->assertStatus(200);
    }

    public function testCreateUser()
    {
        $user = User::factory()->create([
            'name' => 'createUser',
            'email' => 'create@example.com',
            'password' => Hash::make('password'),
        ]);

        $user->syncRoles(['Admin']);

        $response = $this->actingAs($user)->post('/api/user', [
            'name' => 'createUsertest',
            'email' => 'createUsertest@example.com',
            'password' => '4Dejulio.',
            'role' => 'User',
        ]);

        $response->assertStatus(201);
    }
}
