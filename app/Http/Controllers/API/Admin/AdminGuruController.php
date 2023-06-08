<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Guru;
use App\Models\Kode;
use App\Models\Mapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminGuruController extends Controller
{
    public function index()
    {
        $nama_guru = request('nama_guru', null);
        $status_mapel = request('status_mapel', null);
        $data = Guru::join('mapels', 'mapels.id', '=', 'gurus.mapel_id')
        ->when($status_mapel, function ($query) use ($status_mapel){
            $query->where('mapels.status_mapel', $status_mapel);
        })
        ->when($nama_guru, function ($query) use ($nama_guru){
            $query->where('gurus.nama_guru', 'LIKE', '%' . $nama_guru . '%');
        })
        ->select(['gurus.id', 'gurus.niy', 'gurus.foto_profile', 'gurus.nama_guru', 'gurus.email', 'mapels.status_mapel'])->get();

        $jumlah_guru = count(Guru::all());

        return response()->json([
            "success" => true,
            "message" => "List Guru",
            "jumlah_guru" => $jumlah_guru,
            "data" => $data,
        ], 200);
    }

    public function detail($id)
    {
        $mapel = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->where('kodes.guru_id', $id)
        ->select([
            'kodes.nama_mapel',
            'tingkatans.tingkat_ke',
            'jurusans.nama_jurusan',
            'kelas.nama_kelas',
        ])->get();

        $guru = Guru::join('mapels', 'mapels.id', '=', 'gurus.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->where('gurus.id', $id)
        ->select([
            'gurus.id',
            'gurus.foto_profile',
            'gurus.nama_guru',
            'gurus.email',
            // 'kodes.nama_mapel',
            // 'kodes.kode_guru',
            // 'tingkatans.tingkat_ke',
            // 'jurusans.nama_jurusan',
            // 'kelas.nama_kelas',
        ])
        ->first();

        $data = [
            'id'=>$guru->id,
            'niy'=>$guru->niy,
            'foto_profile'=>$guru->foto_profile,
            'nama_guru'=>$guru->nama_guru,
            'email'=>$guru->email,
            'detail'=>$mapel
            // 'profile' => $guru,
            // 'detail' => $mapel
        ];

        return response()->json([
            "success" => true,
            "message" => "Detail Guru",
            "data" => $data
        ], 200);
    }

    public function tambah_guru(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama_guru' => 'required',
            'email' => 'required',
            'password' => 'required',
            'niy' => 'required',
            'foto_profile' => 'required|mimes:jpeg,png,jpg',
            // 'mapel_id' => 'required'
        ]);

        $berkas = $request->file('foto_profile');
        $nama = $berkas->getClientOriginalName();

        $data = Guru::create([
            'nama_guru' => $request->nama_guru,
            'email' => $request->email, 
            'password' => Hash::make($request->password),
            'niy' => $request->niy,
            'foto_profile' => $berkas->storeAs('gambar_profile_guru', $nama),
            'mapel_id' => $request->mapel_id
        ]);

        $data->assignRole($request->role);

        return response()->json([
            'message' => 'Data Guru baru berhasil dibuat',
            'data' => $data,
        ]);
    }

    public function edit_guru(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'nama_guru' => 'required',
            'email' => 'required',
            'password' => 'required',
            'niy' => 'required',
            'foto_profile' => 'required|mimes:jpeg,png,jpg',
            // 'mapel_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => [],
            ]);
        }

        $file_path = Guru::where('id', $id)->value('foto_profile');

        if (Storage::exists($file_path)) {
            Storage::delete($file_path);
            $berkas = $request->file('foto_profile');
            $nama = $berkas->getClientOriginalName();
        } else {
            $berkas = $request->file('foto_profile');
            $nama = $berkas->getClientOriginalName();
        }

        try {
            $guru = Guru::where('id', $id)->first();

            $guru->update([
                'nama_guru' => $request->nama_guru,
                'email' => $request->email, 
                'password' => Hash::make($request->password),
                'niy' => $request->niy,
                'foto_profile' => $berkas->storeAs('gambar_profile_guru', $nama),
                'mapel_id' => $request->mapel_id
            ]);

            // $guru->removeRole('writer');
            // $guru->assignRole($request->role);

            return response()->json([
                'message' => 'Data Kelas berhasil di ubah',
                'data' => $guru,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage(),
            ]);
        }
    }

    public function hapus_guru($id)
    {
        $guru = Guru::where('id', $id)->first();

        $file_path = Guru::where('id', $id)->value('foto_profile');
        Storage::delete($file_path);

        $guru->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data guru berhasil di hapus',
        ]);
    }

    public function tambah_kode(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'kode_guru'=> 'required',
            'nama_mapel'=> 'required',
            'guru_id'=> 'required',
        ]);

        $data = Kode::create([
            'kode_guru'=> $request->kode_guru,
            'nama_mapel'=> $request->nama_mapel,
            'guru_id'=> $id,
        ]);

        return response()->json([
            'message' => 'Data kode guru baru berhasil dibuat',
            'data' => $data,
        ]);
    }
}
