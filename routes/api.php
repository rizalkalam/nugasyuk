<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\GuruController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\Guru\KbmController;
use App\Http\Controllers\API\Murid\TugasController;
use App\Http\Controllers\API\Admin\JadwalController;
use App\Http\Controllers\API\Guru\BerandaController;
use App\Http\Controllers\API\Guru\ProfileController;
use App\Http\Controllers\API\Ortu\OrtuMapelController;
use App\Http\Controllers\API\Ortu\OrtuTugasController;
use App\Http\Controllers\API\Admin\AdminGuruController;
use App\Http\Controllers\API\Ortu\OrtuJadwalController;
use App\Http\Controllers\API\Admin\AdminKelasController;
use App\Http\Controllers\API\Admin\AdminMuridController;
use App\Http\Controllers\API\Guru\PengumpulanController;
use App\Http\Controllers\API\Murid\MuridMapelController;
use App\Http\Controllers\API\Ortu\OrtuBerandaController;
use App\Http\Controllers\API\Murid\MuridJadwalController;
use App\Http\Controllers\API\Admin\AdminBerandaController;
use App\Http\Controllers\API\Murid\MuridBerandaController;
use App\Http\Controllers\API\Murid\MuridProfileController;

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
Route::post('/login', [LoginController::class, 'login'])->name('login.guru');

// token salah
Route::get('/salahtoken', [LoginController::class, 'wrongtoken'])->name('salahtoken');

Route::middleware('auth:admin')->group(function(){
    Route::group(["prefix"=>"admin"], function(){
        // Route logout admin
        Route::get('/logout', [LoginController::class, 'logout']);
        
        // Route beranda admin
        Route::get('/dataadmin', [AdminBerandaController::class, 'data_admin']);

        // Route guru admin
        Route::get('/guru', [AdminGuruController::class, 'index']);
        Route::get('/guru/{id}', [AdminGuruController::class, 'detail']);
    
        // Route murid admin
        Route::get('/murid', [AdminMuridController::class, 'index']);
        Route::post('/murid', [AdminMuridController::class, 'buat_murid']);

        // Route kelas admin
        Route::get('/kelas', [AdminKelasController::class, 'index']);
        Route::post('/kelas', [AdminKelasController::class, 'buat_kelas']);
        Route::post('/kelas/{id}', [AdminKelasController::class, 'edit_kelas']);
        Route::delete('/kelas/{id}', [AdminKelasController::class, 'hapus_kelas']);
    
        // Route jadwal admin
        Route::get('/jadwal/{id}', [JadwalController::class, 'index']);
    });
});

Route::middleware('auth:guru')->group(function(){
    Route::group(["prefix"=>"guru"], function(){
        // logout guru
        Route::get('/logout', [LoginController::class, 'logout']);

        // Route Beranda Guru
        Route::get('/dataguru', [BerandaController::class, 'data_guru']);

        //profile
        Route::get('/profile', [ProfileController::class, 'index']);
        Route::post('/gantipassword', [ProfileController::class, 'resetpassword']);


        Route::get('/kbm', [KbmController::class, 'kbm']);
        Route::get('/materi/kelas/{kelas_id}', [KbmController::class, 'materi']);
        Route::get('/tugas/kelas/{kelas_id}', [KbmController::class, 'tugas']);
        Route::get('/materi/kelas/{kelas_id}/detail/{materi_id}', [KbmController::class, 'detail_materi']);
        Route::get('/tugas/kelas/{kelas_id}/detail/{tugas_id}', [KbmController::class, 'detail_tugas']);
        Route::get('/tugas/kelas/{kelas_id}/detail/{tugas_id}/{status}', [KbmController::class, 'cek_pengumpulan']);
        Route::get('/pengumpulan/{kelas_id?}', [PengumpulanController::class, 'pengumpulan']);
        Route::get('/pengumpulan/detail/{nama}', [PengumpulanController::class, 'detail_pengumpulan']);
        Route::get('/pengumpulan/detail/{nama}/{status}', [PengumpulanController::class, 'status_pengumpulan']);
        Route::get('/pengumpulan/konfirmasi/{murid_id}/{pengumpulan_id}', [PengumpulanController::class, 'konfirmasi']);
        Route::get('/jadwal/{id}', [JadwalController::class, 'index']);

        // crud route materi
        Route::post('/materi/kelas/{kelas_id}/mapel/{nama_mapel}', [KbmController::class, 'buat_materi']);
        Route::post('/materi/kelas/{kelas_id}/mapel/{nama_mapel}/{id}', [KbmController::class, 'edit_materi']);
        Route::delete('/materi/kelas/{kelas_id}/mapel/{nama_mapel}/{id}', [KbmController::class, 'hapus_materi']);

        // crud route tugas
        Route::post('/tugas/kelas/{kelas_Id}/mapel/{nama_mapel}', [KbmController::class, 'buat_tugas']);
        Route::post('/tugas/kelas/{kelas_Id}/mapel/{nama_mapel}/{id}', [KbmController::class, 'edit_tugas']);
        Route::delete('/tugas/kelas/{kelas_Id}/mapel/{nama_mapel}/{id}', [KbmController::class, 'hapus_tugas']);
    });
});

Route::middleware('auth:murid')->group(function(){
    Route::group(["prefix"=>"murid"], function(){

        // Route Profile Murid
        Route::get('/profile', [MuridProfileController::class, 'index']);

        // Route Beranda Murid
        Route::get('/datamurid', [MuridBerandaController::class, 'data_murid']);

        // Route Tugas Murid
        Route::get('/tugas', [TugasController::class, 'tugas']);

        // Route Mapel Murid
        Route::get('/matapelajaran', [MuridMapelController::class, 'index']);
        Route::get('/matapelajaran/{id}', [MuridMapelController::class, 'detail_mapel']);
        Route::get('/matapelajaran/materi/{id}', [MuridMapelController::class, 'materi']);
        Route::get('/matapelajaran/tugas/{id}', [MuridMapelController::class, 'tugas']);

        // Route Jadwal Murid
        Route::get('/jadwal', [MuridJadwalController::class, 'index']);
        Route::get('/jadwal/{id}', [MuridJadwalController::class, 'detail']);

        // logout murid
        Route::get('/logout', [LoginController::class, 'logout']);    
    });
});

Route::middleware('auth:ortu')->group(function(){
    Route::group(["prefix"=>"ortu"], function(){
        // logout ortu
        Route::get('/logout', [LoginController::class, 'logout']);

        // Route Beranda Ortu
        Route::get('/dataortu', [OrtuBerandaController::class, 'data_ortu']);

        // Route Tugas Ortu
        Route::get('/tugas', [OrtuTugasController::class, 'tugas']);

        // Route Jadwal Ortu
        Route::get('/jadwal', [OrtuJadwalController::class, 'index']);
        Route::get('/jadwal/{id}', [OrtuJadwalController::class, 'detail']);

        // Route Mapel Ortu
        Route::get('/matapelajaran', [OrtuMapelController::class, 'index']);
        Route::get('/matapelajaran/{id}', [OrtuMapelController::class, 'detail_mapel']);
        Route::get('/matapelajaran/materi/{id}', [OrtuMapelController::class, 'materi']);
        Route::get('/matapelajaran/tugas/{id}', [OrtuMapelController::class, 'tugas']);
    });
});
