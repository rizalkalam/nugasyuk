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
use App\Http\Controllers\API\Guru\GuruJadwalController;
use App\Http\Controllers\API\Murid\KonselingController;
use App\Http\Controllers\API\Ortu\OrtuJadwalController;
use App\Http\Controllers\API\Admin\AdminAssetController;
use App\Http\Controllers\API\Admin\AdminKelasController;
use App\Http\Controllers\API\Admin\AdminMapelController;
use App\Http\Controllers\API\Admin\AdminMuridController;
use App\Http\Controllers\API\Guru\PengumpulanController;
use App\Http\Controllers\API\Murid\MuridMapelController;
use App\Http\Controllers\API\Ortu\OrtuBerandaController;
use App\Http\Controllers\API\Ortu\OrtuProfileController;
use App\Http\Controllers\API\Murid\MuridJadwalController;
use App\Http\Controllers\API\Admin\AdminBerandaController;
use App\Http\Controllers\API\Admin\AdminProfileController;
use App\Http\Controllers\API\Murid\MuridBerandaController;
use App\Http\Controllers\API\Murid\MuridProfileController;
use App\Http\Controllers\API\Guru\GuruNotificationController;
use App\Http\Controllers\API\Ortu\OrtuNotificationController;
use App\Http\Controllers\API\Konseling\KonselingChatController;
use App\Http\Controllers\API\Murid\MuridNotificationController;
use App\Http\Controllers\API\Konseling\KonselingJanjiController;
use App\Http\Controllers\API\Konseling\KonselingBerandaController;

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

        // Route reset password admin
        Route::post('/ubahpassword', [AdminProfileController::class, 'resetpassword']);

        // Route profile admin
        Route::get('/profile', [AdminProfileController::class, 'index']);
        
        // Route beranda admin
        Route::get('/dataadmin', [AdminBerandaController::class, 'data_admin']);

        // Route guru admin
        Route::get('/guru', [AdminGuruController::class, 'index']);
        Route::get('/guru/{id}', [AdminGuruController::class, 'detail']);
        Route::post('/guru', [AdminGuruController::class, 'tambah_guru']);
        Route::post('/guru/{id}', [AdminGuruController::class, 'edit_guru']);
        Route::delete('/guru/{id}', [AdminGuruController::class, 'hapus_guru']);
    
        // Route murid admin
        Route::get('/murid', [AdminMuridController::class, 'index']);
        Route::get('/murid/{id}', [AdminMuridController::class, 'detail']);
        Route::post('/murid', [AdminMuridController::class, 'buat_murid']);
        Route::post('/murid/{id}', [AdminMuridController::class, 'edit_murid']);
        Route::delete('/murid/{id}', [AdminMuridController::class, 'hapus_murid']);

        // Route kelas admin
        Route::get('/kelas', [AdminKelasController::class, 'index']);
        Route::get('/kelas/{id}', [AdminKelasController::class, 'detail_kelas']);
        Route::post('/kelas', [AdminKelasController::class, 'buat_kelas']);
        Route::post('/kelas/{id}', [AdminKelasController::class, 'edit_kelas']);
        Route::delete('/kelas/{id}', [AdminKelasController::class, 'hapus_kelas']);

        // Route mapel admin
        Route::get('/mapel', [AdminMapelController::class, 'index']);
        Route::get('/mapel/{id}', [AdminMapelController::class, 'detail_mapel']);
        Route::post('/mapel', [AdminMapelController::class, 'buat_mapel']);
        Route::post('/mapel/{id}', [AdminMapelController::class, 'edit_mapel']);
        Route::delete('/mapel/{id}', [AdminMapelController::class, 'hapus_mapel']);
    
        // Route jadwal admin
        Route::get('/jadwal', [JadwalController::class, 'index']);
        Route::get('/jadwal/{id}', [JadwalController::class, 'detail']);
        Route::post('/jadwal', [JadwalController::class, 'buat_jadwal']);
        Route::post('/jadwal/{id}', [JadwalController::class, 'edit_jadwal']);
        Route::delete('/jadwal/{id}', [JadwalController::class, 'hapus_jadwal']);
        Route::get('/jadwal/data/{id}', [JadwalController::class, 'data_jadwal']);

        // Route asset admin
        Route::get('/asset', [AdminAssetController::class, 'index']);
        Route::get('/asset/{id}', [AdminAssetController::class, 'detail_asset']);
        Route::post('/asset', [AdminAssetController::class, 'buat_asset']);
        Route::delete('/asset/{id}', [AdminAssetController::class, 'hapus_asset']);

        // Route kode admin
        Route::post('/kode/{id}', [AdminGuruController::class, 'tambah_kode']);
        Route::delete('/kode/{id}', [AdminGuruController::class, 'hapus_kode']);
    });
});

Route::group(["middleware" => ['GuruBiasa', 'role:guru_biasa'], "prefix"=>"guru"], function(){
    // logout guru
    Route::get('/logout', [LoginController::class, 'logout']);

    // Route Beranda Guru
    Route::get('/dataguru', [BerandaController::class, 'data_guru']);

    // profile
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/ubahpassword', [ProfileController::class, 'resetpassword']);

    // notifikasi
    Route::get('/notifikasi', [GuruNotificationController::class, 'index']);

    // page kbm
    Route::get('/kbm', [KbmController::class, 'kbm']);
    Route::get('/materi/kelas/{kelas_id}', [KbmController::class, 'materi']);
    Route::get('/tugas/kelas/{kelas_id}', [KbmController::class, 'tugas']);
    Route::get('/materi/{materi_id}', [KbmController::class, 'detail_materi']);
    Route::get('/tugas/{tugas_id}', [KbmController::class, 'detail_tugas']);
    Route::get('/detail/pengumpulan/{tugas_id}', [KbmController::class, 'cek_pengumpulan']);
    Route::get('/cek/pengumpulan/menunggu/{id}', [KbmController::class, 'pengumpulan_menunggu']);
    Route::get('/cek/pengumpulan/selesai/{id}', [KbmController::class, 'pengumpulan_selesai']);

    // page pengumpulan
    Route::get('pengumpulan/kelas', [KbmController::class, 'kbm']);
    Route::get('pengumpulan/menunggu/{id}', [PengumpulanController::class, 'pengumpulan_menunggu']);
    Route::get('pengumpulan/selesai/{id}', [PengumpulanController::class, 'pengumpulan_selesai']);



    Route::get('/pengumpulan', [PengumpulanController::class, 'pengumpulan']);
    Route::get('/pengumpulan/{id}', [PengumpulanController::class, 'detail_pengumpulan']);
    Route::get('/pengumpulan/detail/{id}', [PengumpulanController::class, 'status_pengumpulan']);
    Route::get('/pengumpulan/konfirmasi/{murid_id}/{pengumpulan_id}', [PengumpulanController::class, 'konfirmasi']);

    // Route Jadwal
    Route::get('/jadwal', [GuruJadwalController::class, 'index']);
    Route::get('/jadwal/{id}', [JadwalController::class, 'index']);

    // crud route materi
    
    Route::post('/materi/kelas/{kelas_id}/mapel/{mapel_id}', [KbmController::class, 'buat_materi']);
    Route::post('/materi/kelas/{kelas_id}/mapel/{mapel_id}/materi/{id}', [KbmController::class, 'edit_materi']);
    Route::delete('/materi/kelas/{kelas_id}/mapel/{mapel_id}/materi/{id}', [KbmController::class, 'hapus_materi']);

    // crud route tugas
    
    Route::post('/tugas/kelas/{kelas_id}/mapel/{mapel_id}', [KbmController::class, 'buat_tugas']);
    Route::post('/tugas/kelas/{kelas_id}/tugas/{tugas_id}', [KbmController::class, 'edit_tugas']);
    Route::delete('/tugas/kelas/{kelas_id}/tugas/{tugas_id}', [KbmController::class, 'hapus_tugas']);

    // cek pengumpulan
    
});

Route::middleware('auth:murid')->group(function(){
    Route::group(["prefix"=>"murid"], function(){

        // Route Profile Murid
        Route::get('/profile', [MuridProfileController::class, 'index']);
        Route::post('/ubahpassword', [MuridProfileController::class, 'resetpassword']);

        // notifikasi
        Route::get('/notifikasi', [MuridNotificationController::class, 'index']);

        // Route Beranda Murid
        Route::get('/datamurid', [MuridBerandaController::class, 'data_murid']);

        // Route Tugas Murid
        Route::get('/tugas', [TugasController::class, 'tugas']);
        Route::get('/tugas/{id}', [TugasController::class, 'detail']);
        Route::post('/tugas/{id}', [TugasController::class, 'kirim']);
        

        // Route Mapel Murid
        Route::get('/matapelajaran', [MuridMapelController::class, 'index']);
        Route::get('/matapelajaran/{id}', [MuridMapelController::class, 'detail_mapel']);
        Route::get('/matapelajaran/materi/{id}', [MuridMapelController::class, 'materi']);
        Route::get('/materi/{id}', [MuridMapelController::class, 'detail_materi']);
        Route::get('/matapelajaran/tugas/{id}', [MuridMapelController::class, 'tugas']);

        // Route Jadwal Murid
        Route::get('/jadwal', [MuridJadwalController::class, 'index']);
        Route::get('/jadwal/{id}', [MuridJadwalController::class, 'detail']);

        // Route Konseling Murid
        Route::get('percakapan/{user_one}', [KonselingController::class, 'show'])->name('percakapan.show');
        Route::post('percakapan/{percakapan}/pesan', [KonselingController::class, 'store'])->name('percakapan.store');

        // logout murid
        Route::get('/logout', [LoginController::class, 'logout']);    
    });
});

Route::middleware('auth:ortu')->group(function(){
    Route::group(["prefix"=>"ortu"], function(){
        // logout ortu
        Route::get('/logout', [LoginController::class, 'logout']);

        // profile ortu
        Route::get('/profile', [OrtuProfileController::class, 'index']);
        Route::post('/ubahpassword', [OrtuProfileController::class, 'resetpassword']);

        // notifikasi
        Route::get('/notifikasi', [OrtuNotificationController::class, 'index']);

        // Route Beranda Ortu
        Route::get('/dataortu', [OrtuBerandaController::class, 'data_ortu']);

        // Route Tugas Ortu
        Route::get('/tugas', [OrtuTugasController::class, 'tugas']);
        Route::get('/tugas/{id}', [OrtuTugasController::class, 'detail']);

        // Route Jadwal Ortu
        Route::get('/jadwal', [OrtuJadwalController::class, 'index']);
        Route::get('/jadwal/{id}', [OrtuJadwalController::class, 'detail']);

        // Route Mapel Ortu
        Route::get('/matapelajaran', [OrtuMapelController::class, 'index']);
        Route::get('/matapelajaran/{id}', [OrtuMapelController::class, 'detail_mapel']);
        Route::get('/matapelajaran/materi/{id}', [OrtuMapelController::class, 'materi']);
        Route::get('/matapelajaran/tugas/{id}', [OrtuMapelController::class, 'tugas']);
        Route::get('/materi/{id}', [OrtuMapelController::class, 'detail_materi']);
    });
});

Route::group(["middleware" => ['GuruKonseling', 'role:guru_bk'], "prefix" => "konseling"], function(){
    Route::get('/datakonseling', [KonselingBerandaController::class, 'index']);

    // CHAT KONSELING
    Route::get('percakapan/{user_two}', [KonselingChatController::class, 'show'])->name('percakapan.show');
    Route::post('percakapan/{percakapan}/pesan', [KonselingChatController::class, 'store'])->name('percakapan.store');

    // Route Buat Janji Konseling

});
