<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Guru;
use App\Models\Ortu;
use App\Models\Murid;
use Database\Seeders\GuruSeeder;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    // /** @test */
    // public function guru_masuk_halaman_login()
    // {
    //     $response = $this->get('/login');
 
    //     $response->assertStatus(200);
    // }
    
    /** @test */
    public function guru_bisa_login_dengan_kredensial()
    {
// <<<<<<< Updated upstream
//         $guru = Guru::factory()->create();

//         $response = $this->postJson(route('login.guru'), [
//             'email' => $guru->email,
//             'password' => 'password'
//         ])->assertOk();

//         $this->assertArrayHasKey('token', $response->json());
//     }

//     /** @test */
//     public function guru_tidak_bisa_login_dengan_kredensial_salah()
//     {
//         $guru = Guru::factory()->create();

//         $response = $this->postJson(route('login.guru'), [
//             'email' => $guru->email,
//             'password' => 'wrong password'
//         ])->assertUnauthorized();

//         $this->assertArrayHasKey('error', $response->json());
//     }

//     /** @test */
//     public function murid_bisa_login_dengan_kredensial()
//     {
//         $murid = Murid::factory()->create();

//         $response = $this->postJson(route('login.murid'), [
//             'email' => $murid->email,
//             'password' => 'password'
//         ])->assertOk();

//         $this->assertArrayHasKey('token', $response->json());
//     }

//     /** @test */
//     public function murid_tidak_bisa_login_dengan_kredensial_salah()
//     {
//         $murid = Murid::factory()->create();

//         $response = $this->postJson(route('login.murid'), [
//             'email' => $murid->email,
//             'password' => 'wrong password'
//         ])->assertUnauthorized();

//         $this->assertArrayHasKey('error', $response->json());
//     }

//     /** @test */
//     public function ortu_bisa_login_dengan_kredensial()
//     {
//         $ortu = Ortu::factory()->create();

//         $response = $this->postJson(route('login.ortu'), [
//             'email' => $ortu->email,
//             'password' => 'password'
//         ])->assertOk();

//         $this->assertArrayHasKey('token', $response->json());
//     }

//     /** @test */
//     public function ortu_tidak_bisa_login_dengan_kredensial_salah()
//     {
//         $ortu = Ortu::factory()->create();

//         $response = $this->postJson(route('login.ortu'), [
//             'email' => $ortu->email,
//             'password' => 'wrong password'
//         ])->assertUnauthorized();

//         $this->assertArrayHasKey('error', $response->json());
// =======
//         $guru = \App\Models\Guru::factory()->create();

//         $response = $this->post('/login/guru', [
//             'email' => $guru->email,
//             'password' => 'password'
//         ]);

//         $this->assertAuthenticated();
//         $response->assertStatus(200);
// >>>>>>> Stashed changes
    }
}
