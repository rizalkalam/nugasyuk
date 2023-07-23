<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Ortu;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Murid;
use App\Models\Percakapan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AdminListMuridResource;

class AdminMuridController extends Controller
{
    public function index()
    {
        $jurusan = request('jurusan', null);
        $murid = Murid::leftjoin('kelas', 'kelas.id', '=', 'murids.kelas_id')
        ->leftjoin('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->leftjoin('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->when($jurusan, function ($query) use ($jurusan){
            $query->where('jurusans.id', $jurusan);
        })
        // ->whereNull('jurusans.nama_jurusan')
        ->orderBy('murids.id', 'ASC')
        ->select([
            'murids.id',
            'murids.nis',
            'murids.foto_profile',
            'murids.nama_siswa',
            'murids.email',
            'jurusans.nama_jurusan'
        ])
        ->get();

        $data = AdminListMuridResource::collection($murid);

        $jumlah_murid = count(Murid::all());

        return response()->json([
            "success" => true,
            "message" => "List Siswa",
            "jumlah_siswa" => $jumlah_murid,
            "data" => $data
        ], 200);
    }

    public function detail($id)
    {
        $siswa = Murid::leftjoin('kelas', 'kelas.id', '=', 'murids.kelas_id')
        ->leftjoin('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->leftjoin('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->where('murids.id', $id)
        ->select([
            'murids.id',
            'murids.foto_profile',
            'murids.nis',
            'murids.nama_panggilan',
            'murids.nama_siswa',
            'murids.email',
            'murids.alamat',
            'jurusans.nama_jurusan',
            'kelas.nama_kelas',
            'tingkatans.tingkat_ke',
            // 'ortus.email'
        ])->first();

        $kelas_id =  Murid::join('kelas', 'kelas.id', '=', 'murids.kelas_id')
        ->where('murids.id', $id)
        ->value('kelas.id');

        $data_ortu = Ortu::join('murids', 'murids.id', '=', 'ortus.siswa_id')
        ->where('siswa_id', $id)->select(['ortus.nama','ortus.email'])->first();

        $data = [
            'id'=>$siswa->id,
            'nis'=>$siswa->nis,
            'foto_profile'=>$siswa->foto_profile,
            'nama_panggilan'=>$siswa->nama_panggilan,
            'nama_siswa'=>$siswa->nama_siswa,
            'email'=>$siswa->email,
            'alamat'=>$siswa->alamat,
            'tingkat_ke'=>$siswa->tingkat_ke !== null ? $siswa->tingkat_ke : 0,
            'jurusan'=>$siswa->nama_jurusan !== null ? $siswa->nama_jurusan : 0,
            'kelas'=>$siswa->nama_kelas !== null ? $siswa->nama_kelas : 0,
            'kelas_id'=>$kelas_id !== null ? $kelas_id : 0,
            'nama_wali_murid'=>$data_ortu->nama,
            'email_wali_murid'=>$data_ortu->email
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
            'nis'=>'required|unique:murids',
            'nama_panggilan'=>'required',
            'nama_siswa'=> 'required',
            'email'=> 'required|email|unique:murids',
            'password'=> 'required',
            'alamat'=>'required',
            'foto_profile'=> 'required|mimes:jpeg,png,jpg|file|max:2048',
            'kelas_id'=> 'required',

            // validasi input wali murid
            'nama'=>'required',
            'email_wali'=>'required|email|unique:ortus,email',
            'password'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => [],
            ], 400);
        }

        $berkas = $request->file('foto_profile');
        $nama = time().'-'.$berkas->getClientOriginalName();

        try {
            $data = Murid::create([
                'nis' => $request->nis,
                'nama_panggilan'=>$request->nama_panggilan,
                'nama_siswa' => $request->nama_siswa,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'alamat'=> $request->alamat,
                'foto_profile' => $berkas->storeAs('gambar_profile_siswa',$nama),
                'kelas_id' => $request->kelas_id
            ]);
    
            $wali_murid = Ortu::create([
                'nama'=>$request->nama,
                'email'=>$request->email_wali,
                'password'=>Hash::make($request->password_wali),
                'siswa_id'=>Murid::latest()->first()->id
            ]);

            $guru_id = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
            ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
            ->where('mapels.kelas_id', Murid::latest()->first()->kelas_id)
            ->where('kodes.status_mapel', 'bk')
            ->first();

            $percakapan = Percakapan::insert([
                'user_one' => $guru_id->id,
                'user_two' => Murid::latest()->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
    
            return response()->json([
                'message' => 'Data Siswa dan Wali Murid baru berhasil dibuat',
                'siswa' => $data,
                'wali_murid' => $wali_murid
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage(),
            ], 400);
        }
    }

    public function edit_murid(Request $request, $id)
    {
        $wali_id = Ortu::where('siswa_id', $id)->select('id')->get();

        $validator = Validator::make($request->all(),[
            'nis'=>'required|unique:murids,nis,' . $id,
            'nama_panggilan'=>'required',
            'nama_siswa'=> 'required',
            'email'=> 'required|email|unique:murids,email,' . $id,
            'password'=> 'required',
            'foto_profile'=> 'mimes:jpeg,png,jpg|file|max:2048',
            'alamat'=> 'required',
            'kelas_id'=> 'required',

             // validasi input wali murid
             'nama'=>'required',
             'email_wali'=>'required|email|unique:ortus,email,' . $wali_id,
             'password'=>'required',
            //  'siswa_id'=>'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => [],
            ], 400);
        }

        $file_path = Murid::where('id', $id)->value('foto_profile');

        if ($request->hasFile('foto_profile')) {
            Storage::delete($file_path);
            $berkas = $request->file('foto_profile');
            $nama = time().'-'.$berkas->getClientOriginalName();
            $edit = $berkas->storeAs('gambar_profile_siswa', $nama);
        } else {
            $edit = $file_path;
        }

        try {
            $murid = Murid::where('id', $id)->first();

            $murid->update([
                'nis' => $request->nis,
                'nama_panggilan'=>$request->nama_panggilan,
                'nama_siswa' => $request->nama_siswa,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'alamat' => $request->alamat,
                'foto_profile' => $edit,
                'kelas_id' => $request->kelas_id
            ]);

            $ortu = Ortu::where('siswa_id', $id)->first();
            $wali_id->update([
                'nama'=>$request->nama,
                'email'=>$request->email_wali,
                'password'=>Hash::make($request->password_wali),
                // 'siswa_id'=>Murid::latest()->first()->id
            ]);

            $guru_id = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
            ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
            ->where('kodes.status_mapel', 'bk')
            ->where('mapels.kelas_id', $request->kelas_id)
            ->first();

            $data_percakapan = Percakapan::whereIn('user_two', array($id))
            ->update([
                'user_one' => $guru_id->id,
                'user_two' => $id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            // $percakapan = [];
            // foreach ($murid as $id) {
            //     $percakapan[] = [
            //         'user_one' => $guru,
            //         'user_two' => $id->id,
            //         'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            //         'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            //     ];
            // }

            // Percakapan::insert($percakapan);

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
            ], 400);
        }
    }

    public function hapus_murid($id)
    {
        $file_path = Murid::where('id', $id)->value('foto_profile');
        Storage::delete($file_path);
        $murid = Murid::where('id', $id)->first();

        $ortu = Ortu::where('siswa_id', $id)->first();

        $data_percakapan = Percakapan::whereIn('user_two', array($id))->delete();

        $ortu->delete();
        $murid->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data murid berhasil di hapus',
        ]);
    }
}
