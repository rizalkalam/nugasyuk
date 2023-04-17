<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\GuruController;
use App\Http\Controllers\API\LoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login/guru', [LoginController::class, 'loginGuru']);
Route::post('/login/murid', [LoginController::class, 'loginMurid']);
Route::post('/login/ortu', [LoginController::class, 'loginOrtu']);

Route::middleware('auth:guru')->group(function(){
    Route::get('/beranda', [GuruController::class, 'beranda']);
    Route::get('/profile', [GuruController::class, 'profile']);
    Route::get('/kbm', [GuruController::class, 'kbm']);
    Route::get('/materi/kelas/{kelas_id}', [GuruController::class, 'materi']);
    Route::get('/tugas/kelas/{kelas_id}', [GuruController::class, 'tugas']);
    Route::get('/materi/kelas/{kelas_id}/detail/{materi_id}', [GuruController::class, 'detail_materi']);
    Route::get('/tugas/kelas/{kelas_id}/detail/{tugas_id}', [GuruController::class, 'detail_tugas']);
    Route::get('/tugas/kelas/{kelas_id}/detail/{tugas_id}/{status}', [GuruController::class, 'cek_pengumpulan']);
    Route::get('/pengumpulan/{kelas_id?}', [GuruController::class, 'pengumpulan']);
    Route::get('/pengumpulan/detail/{nama}', [GuruController::class, 'detail_pengumpulan']);
    Route::get('/pengumpulan/detail/{nama}/{status}', [GuruController::class, 'status_pengumpulan']);

    // crud route
    Route::post('buat/materi/kelas/{kelas_Id}/mapel/{nama_mapel}', [GuruController::class, 'buat_materi']);
    // Route::get('/tugas/kelas/{kelas_id}/mapel/{nama_mapel}/buat', [GuruController::class, 'buat_tugas']);

    Route::post('buat/tugas/kelas/{kelas_Id}/mapel/{nama_mapel}', [GuruController::class, 'buat_tugas']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
