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
        // $guru = Guru::when($nama_guru, function ($query) use ($nama_guru){
        //     $query->where('gurus.nama_guru', 'LIKE', '%' . $nama_guru . '%');
        // })
        // ->select(['gurus.id', 'gurus.niy', 'gurus.foto_profile', 'gurus.nama_guru', 'gurus.email'])->get();
        
        
        $nama_guru = request('nama_guru', null);
        $status_mapel = request('status_mapel', null);
        $data = Guru::leftjoin('kodes', 'kodes.id', '=', 'gurus.kode_id')
        ->when($status_mapel, function ($query) use ($status_mapel){
            $query->where('kodes.status_mapel', $status_mapel);
        })
        ->when($nama_guru, function ($query) use ($nama_guru){
            $query->where('gurus.nama_guru', 'LIKE', '%' . $nama_guru . '%');
        })
        ->select(['gurus.id', 'gurus.niy', 'gurus.foto_profile', 'gurus.nama_guru', 'gurus.email', 'kodes.status_mapel'])->get();

        $jumlah_guru = count(Guru::all());

        // $data = [
        //     'id'=>$guru->id
        // ];

        return response()->json([
            "success" => true,
            "message" => "List Guru",
            "jumlah_guru" => $jumlah_guru,
            "data" => $data,
        ], 200);
    }

    public function detail($id)
    {
        $mapel = Mapel::leftjoin('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->where('kodes.guru_id', $id)
        ->select([
            'kodes.kode_guru',
            'kodes.nama_mapel',
            'tingkatans.tingkat_ke',
            'jurusans.nama_jurusan',
            'kelas.nama_kelas',
        ])->get();

        // $guru = Guru::join('mapels', 'mapels.id', '=', 'gurus.mapel_id')
        // ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        // ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
        // ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        // ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        // ->where('gurus.id', $id)
        // ->select([
        //     'gurus.id',
        //     'gurus.niy',
        //     'gurus.foto_profile',
        //     'gurus.nama_guru',
        //     'gurus.email',
        //     'gurus.nomor_tlp',
        //     'gurus.alamat'
        //     // 'kodes.nama_mapel',
        //     // 'kodes.kode_guru',
        //     // 'tingkatans.tingkat_ke',
        //     // 'jurusans.nama_jurusan',
        //     // 'kelas.nama_kelas',
        // ])
        // ->first();

        $guru = Guru::leftjoin('kodes', 'kodes.id', '=', 'gurus.kode_id')
        ->where('gurus.id', $id)
        ->select([
            'gurus.id',
            'gurus.niy',
            'gurus.foto_profile',
            'gurus.nama_guru',
            'gurus.email',
            'gurus.nomor_tlp',
            'gurus.alamat'
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
            'nomor_tlp'=>$guru->nomor_tlp,
            'alamat'=>$guru->alamat,
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
            'nomor_tlp' => 'required|number',
            'alamat' => 'required'
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
            'nomor_tlp' => $request->nomor_tlp,
            'alamat' => $request->alamat,
            // 'kode_id' => $request->kode_id
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
            'email' => 'email',
            'foto_profile' => 'mimes:jpeg,png,jpg',
            'nama_guru' => 'required',
            'password' => 'required',
            'niy' => 'required',
            // 'kode_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => [],
            ]);
        }

        $file_path = Guru::where('id', $id)->value('foto_profile');

        // if (Storage::exists($file_path)) {
        //     Storage::delete($file_path);
        //     $berkas = $request->file('foto_profile');
        //     $nama = $berkas->getClientOriginalName();
        // }
        // elseif ($request->hasFile('foto_profile')) {
        //     $berkas = $request->file('foto_profile');
        //     $nama = $berkas->getClientOriginalName();
        // }

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
                'nomor_tlp' => $request->nomor_tlp,
                'alamat' => $request->alamat,
                // 'kode_id' => $request->kode_id
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
        
        $file_path = Guru::where('id', $id)->value('foto_profile');
        Storage::delete($file_path);
        
        $kode = Kode::where('guru_id', $id);
        $kode->delete();
        
        $guru = Guru::where('id', $id)->first();
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
            'status_mapel'=> 'required',
            'guru_id'=> 'required',
        ]);

        $data = Kode::create([
            'kode_guru'=> $request->kode_guru,
            'nama_mapel'=> $request->nama_mapel,
            'status_mapel'=> $request->status_mapel,
            'guru_id'=> $id,
        ]);

        $guru = Guru::where('id', $id)->first();
        $guru->update([
            'kode_id' => $data->id
        ]);

        return response()->json([
            'message' => 'Data kode guru baru berhasil dibuat',
            'data' => $data,
        ]);
    }
}
