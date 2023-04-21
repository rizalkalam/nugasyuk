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
        // $guru = Guru::factory()->create();

        $this->json('POST', '/login/guru', [
            'email' => 'jokoarysbi@gmail.com',
            'password' => 'mrjack123'
        ])->seeJson([
            'account' => 'jokoarysbi@gmail.com'
        ]);

        
        // $this->assertAuthenticated();

        // $response->assertStatus(200);
    }
}
