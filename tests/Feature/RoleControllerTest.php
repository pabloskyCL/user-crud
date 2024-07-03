<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class RoleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRolesIndex()
    {
        $response = $this->get('/api/role')->json();

        assertEquals([
            ['name' => 'Admin'], ['name' => 'User'],
        ], $response);
    }
}
