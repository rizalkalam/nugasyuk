<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\GuruController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\Guru\KbmController;
use App\Http\Controllers\API\Guru\PengumpulanController;

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
    Route::get('/kbm', [KbmController::class, 'kbm']);
    Route::get('/materi/kelas/{kelas_id}', [KbmController::class, 'materi']);
    Route::get('/tugas/kelas/{kelas_id}', [KbmController::class, 'tugas']);
    Route::get('/materi/kelas/{kelas_id}/detail/{materi_id}', [KbmController::class, 'detail_materi']);
    Route::get('/tugas/kelas/{kelas_id}/detail/{tugas_id}', [KbmController::class, 'detail_tugas']);
    Route::get('/tugas/kelas/{kelas_id}/detail/{tugas_id}/{status}', [KbmController::class, 'cek_pengumpulan']);
    Route::get('/pengumpulan/{kelas_id?}', [PengumpulanController::class, 'pengumpulan']);
    Route::get('/pengumpulan/detail/{nama}', [PengumpulanController::class, 'detail_pengumpulan']);
    Route::get('/pengumpulan/detail/{nama}/{status}', [PengumpulanController::class, 'status_pengumpulan']);

    // crud route materi
    Route::post('/materi/kelas/{kelas_Id}/mapel/{nama_mapel}', [KbmController::class, 'buat_materi']);
    Route::post('/materi/kelas/{kelas_id}/mapel/{nama_mapel}/{id}', [KbmController::class, 'edit_materi']);
    Route::delete('/materi/kelas/{kelas_id}/mapel/{nama_mapel}/{id}', [KbmController::class, 'hapus_materi']);

    // crud route tugas
    Route::post('/tugas/kelas/{kelas_Id}/mapel/{nama_mapel}', [KbmController::class, 'buat_tugas']);
    Route::post('/tugas/kelas/{kelas_Id}/mapel/{nama_mapel}/{id}', [KbmController::class, 'edit_tugas']);
    Route::delete('/tugas/kelas/{kelas_Id}/mapel/{nama_mapel}/{id}', [KbmController::class, 'hapus_tugas']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
