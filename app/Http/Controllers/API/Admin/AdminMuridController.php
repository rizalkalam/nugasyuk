<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Ortu;
use App\Models\Kelas;
use App\Models\Murid;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminMuridController extends Controller
{
    public function index()
    {
        $jurusan = request('jurusan', null);
        // $jurusan_id = Kelas::join('jurusans', function ($query) use ($jurusan){
        //     $query->on('jurusans.id', '=', 'kelas.jurusan_id')
        //           ->where('jurusans.id', $jurusan);
        // })->value('jurusans.id');

        $data = Murid::join('kelas', 'kelas.id', '=', 'murids.kelas_id')
        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->when($jurusan, function ($query) use ($jurusan){
            $query->where('jurusans.id', $jurusan);
        })
        ->orderBy('murids.id', 'ASC')
        ->select(['murids.id', 'murids.nis', 'murids.foto_profile', 'murids.nama_siswa', 'murids.email', 'jurusans.nama_jurusan'])->get();

        $jumlah_murid = count(Murid::all());

        return response()->json([
            "success" => true,
            "message" => "List Siswa",
            "jumlah_siswa" => $jumlah_murid,
            "data" => $data,
        ], 200);
    }

    public function detail($id)
    {
        $siswa = Murid::join('kelas', 'kelas.id', '=', 'murids.kelas_id')
        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->where('murids.id', $id)
        ->select([
            'murids.id',
            'murids.nis',
            'murids.nama_panggilan',
            'murids.nama_siswa',
            'murids.email',
            // 'alamat',
            'jurusans.nama_jurusan',
            'kelas.nama_kelas',
            'tingkatans.tingkat_ke',
            // 'ortus.email'
        ])->first();

        $email_ortu = Ortu::join('murids', 'murids.id', '=', 'ortus.siswa_id')
        ->where('siswa_id', $id)->value('ortus.email');

        $data = [
            'id'=>$siswa->id,
            'nama_panggilan'=>$siswa->nama_panggilan,
            'nama_siswa'=>$siswa->nama_siswa,
            'email'=>$siswa->email,
            'tingkat_ke'=>$siswa->tingkat_ke,
            'jurusan'=>$siswa->nama_jurusan,
            'kelas'=>$siswa->nama_kelas,
            'nis'=>$siswa->nis,
            'email_wali_murid'=>$email_ortu
        ];

        return response()->json([
            "success" => true,
            "message" => "Detail Siswa",
            "data" => $data,
        ], 200);
    }

    public function buat_murid(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nis'=>'required',
            'nama_panggilan'=>'required',
            'nama_siswa'=> 'required',
            'email'=> 'required',
            'password'=> 'required',
            'foto_profile'=> 'required|mimes:jpeg,png,jpg|file|max:2048',
            'kelas_id'=> 'required',

            // validasi input wali murid
            'nama'=>'required',
            'email'=>'required',
            'password'=>'required',
            'siswa_id'=>'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => [],
            ]);
        }

        $berkas = $request->file('foto_profile');
        $nama = $berkas->getClientOriginalName();

        try {
            $data = Murid::create([
                'nis' => $request->nis,
                'nama_panggilan'=>$request->nama_panggilan,
                'nama_siswa' => $request->nama_siswa,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'foto_profile' => $berkas->storeAs('gambar_profile_siswa',$nama),
                'kelas_id' => $request->kelas_id
            ]);
    
            $wali_murid = Ortu::create([
                'nama'=>$request->nama,
                'email'=>$request->email_wali,
                'password'=>Hash::make($request->password_wali),
                'siswa_id'=>Murid::latest()->first()->id
            ]);
    
            return response()->json([
                'message' => 'Data Siswa dan Wali Murid baru berhasil dibuat',
                'siswa' => $data,
                'wali_murid' => $wali_murid
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage(),
            ]);
        }
    }

    public function edit_murid(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'nis'=>'required',
            'nama_panggilan'=>'required',
            'nama_siswa'=> 'required',
            'email'=> 'required',
            'password'=> 'required',
            'foto_profile'=> 'mimes:jpeg,png,jpg|file|max:2048',
            'kelas_id'=> 'required',

             // validasi input wali murid
             'nama'=>'required',
             'email'=>'required',
             'password'=>'required',
            //  'siswa_id'=>'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => [],
            ]);
        }

        $file_path = Murid::where('id', $id)->value('foto_profile');

        if (Storage::exists($file_path)) {
            Storage::delete($file_path);
            $berkas = $request->file('foto_profile');
            $nama = $berkas->getClientOriginalName();
        } else {
            $berkas = $request->file('foto_profile');
            $nama = $berkas->getClientOriginalName();
        }

        try {
            $murid = Murid::where('id', $id)->first();

            $murid->update([
                'nis' => $request->nis,
                'nama_panggilan'=>$request->nama_panggilan,
                'nama_siswa' => $request->nama_siswa,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'foto_profile' => $berkas->storeAs('gambar_profile_siswa', $nama),
                'kelas_id' => $request->kelas_id
            ]);

            $ortu = Ortu::where('siswa_id', $id)->first();
            $ortu->update([
                'nama'=>$request->nama,
                'email'=>$request->email_wali,
                'password'=>Hash::make($request->password_wali),
                // 'siswa_id'=>Murid::latest()->first()->id
            ]);

            return response()->json([
                'message' => 'Data Siswa dan Wali Murid berhasil di ubah',
                'siswa' => $murid,
                'wali_murid' => $ortu
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage(),
            ]);
        }
    }

    public function hapus_murid($id)
    {
        $file_path = Murid::where('id', $id)->value('foto_profile');
        Storage::delete($file_path);
        $murid = Murid::where('id', $id)->first();

        $ortu = Ortu::where('siswa_id', $id)->first();

        $ortu->delete();
        $murid->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data murid berhasil di hapus',
        ]);
    }
}
