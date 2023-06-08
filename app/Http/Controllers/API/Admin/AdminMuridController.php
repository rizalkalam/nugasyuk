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
        $jurusan_id = Kelas::join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->when($jurusan, function ($query) use ($jurusan){
                return $query->whereHas('jurusan', function ($query) use ($jurusan) {
                    $query->where('id', $jurusan);
                });
            })->select(['jurusans.id'])->first();

        $data = Murid::join('kelas', 'kelas.id', '=', 'murids.kelas_id')
        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->where('jurusans.id', $jurusan_id->id)
        ->select(['murids.id', 'murids.nama_siswa', 'murids.email', 'jurusans.nama_jurusan'])->get();

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
            'murids.nama_siswa',
            'murids.email',
            // 'murids.nis',
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
            'nama_siswa'=>$siswa->nama_siswa,
            'email'=>$siswa->email,
            'tingkat_ke'=>$siswa->tingkat_ke,
            'jurusan'=>$siswa->nama_jurusans,
            'kelas'=>$siswa->nama_kelas,
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
            'nama_siswa'=> 'required',
            'email'=> 'required',
            'password'=> 'required',
            'foto_profile'=> 'required|mimes:jpeg,png,jpg',
            'kelas_id'=> 'required'
        ]);

        $berkas = $request->file('foto_profile');
        $nama = $berkas->getClientOriginalName();

        $data = Murid::create([
            'nama_siswa' => $request->nama_siswa,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'foto_profile' => $berkas->storeAs('gambar_profile_siswa',$nama),
            'kelas_id' => $request->kelas_id
        ]);

        return response()->json([
            'message' => 'Data Siswa baru berhasil dibuat',
            'data' => $data,
        ]);
    }

    public function edit_murid(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'nama_siswa'=> 'required',
            'email'=> 'required',
            'password'=> 'required',
            'foto_profile'=> 'required',
            'kelas_id'=> 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => [],
            ]);
        }

        try {
            $murid = Murid::where('id', $id)->first();

            $murid->update([
                'nama_siswa' => $request->nama_siswa,
                'email' => $request->email,
                'password' => $request->password,
                'foto_profile' => $request->foto_profile,
                'kelas_id' => $request->kelas_id
            ]);

            return response()->json([
                'message' => 'Data Kelas berhasil di ubah',
                'data' => $murid,
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
        $murid = Murid::where('id', $id)->first();

        $murid->delete();
        return response()->json([
            'success' => true,
            'message' => 'materi berhasil di hapus',
        ]);
    }
}
