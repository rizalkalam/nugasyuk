<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Guru;
use Database\Seeders\GuruSeeder;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function guru_bisa_login_dengan_kredensial()
    {
        $guru = Guru::factory()->create();

        $response = $this->postJson(route('login.guru'), [
            'email' => $guru->email,
            'password' => 'password'
        ])->assertOk();

        $this->assertArrayHasKey('token', $response->json());
    }
}
