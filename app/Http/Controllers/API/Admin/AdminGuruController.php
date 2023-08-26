<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Guru;
use App\Models\Kode;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Murid;
use App\Models\Percakapan;
use App\Exports\ExportGuru;
use App\Imports\ImportGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\EditDataGuru;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AdminListGuruResource;

class AdminGuruController extends Controller
{
    public function index()
    {
        $nama_guru = request('nama_guru', null);
        $status_mapel = request('status_mapel', null);

        $guru = Guru::leftjoin('kodes', 'kodes.id', '=', 'gurus.kode_id')
        ->when($status_mapel, function ($query) use ($status_mapel){
            $query->where('kodes.status_mapel', $status_mapel);
        })
        ->when($nama_guru, function ($query) use ($nama_guru){
            $query->where('gurus.nama_guru', 'LIKE', '%' . $nama_guru . '%');
        })
        // ->orderBy('gurus.niy', 'ASC')
        ->orderBy('gurus.nama_guru', 'ASC')
        ->select([
            'gurus.id',
            'gurus.niy',
            'gurus.foto_profile',
            'gurus.nama_guru',
            'gurus.email',
            'kodes.status_mapel'
        ])
        ->get();

        $data = AdminListGuruResource::collection($guru);

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
        $kode = Kode::where('guru_id', '=', $id)
        ->select([
            'kodes.id',
            'kodes.kode_guru',
            // 'kodes.nama_mapel',
        ])->get();

        $mapel = Kode::where('guru_id', '=', $id)
        ->select([
            'kodes.nama_mapel',
        ])->get();

        $kelas = Mapel::leftjoin('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->leftjoin('kelas', 'kelas.id', '=', 'mapels.kelas_id')
        ->leftjoin('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->leftjoin('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->where('kodes.guru_id', '=', $id)
        ->whereNotNull('kelas.nama_kelas')
        ->select([
            // 'kodes.kode_guru',
            // 'kodes.nama_mapel',
            'tingkatans.tingkat_ke',
            'jurusans.nama_jurusan',
            'kelas.nama_kelas',
        ])->get();

        $guru = Guru::leftjoin('kodes', 'kodes.id', '=', 'gurus.kode_id')
        ->where('gurus.id', $id)
        ->select([
            'gurus.id',
            'gurus.niy',
            'gurus.foto_profile',
            'gurus.nama_guru',
            'gurus.email',
            'gurus.nomor_tlp',
            'gurus.alamat',
        ])
        ->first();

        $wali_kelas = Kelas::join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->where('guru_id', $id)
        ->select([
            'tingkatans.tingkat_ke',
            'jurusans.nama_jurusan',
            'kelas.nama_kelas'
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
            'mengajar'=>$mapel,
            'kode'=>$kode,
            'mengajar_kelas'=>!empty($kelas->first()) ? $kelas : [],
            'wali_kelas'=>!empty($wali_kelas) ? $wali_kelas : []
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
            'email' => 'required|email|unique:gurus|unique:murids|unique:admins',
            'niy' => 'required|unique:gurus',
            'foto_profile' => 'required|file|max:2048|mimes:jpeg,png,jpg',
            'nomor_tlp' => 'required',
            'alamat' => 'required'
            // 'password' => 'required',
            // 'mapel_id' => 'required'
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
            if (empty(explode(' ',trim($request->nama_guru))[1])) {
                $kostumisasi_password = Carbon::now()->format('Y').'_'.explode(' ',trim($request->nama_guru))[0].'_'.$request->niy;
            } else {
                $kostumisasi_password = Carbon::now()->format('Y').'_'.explode(' ',trim($request->nama_guru))[0].'_'.explode(' ',trim($request->nama_guru))[1].'_'.$request->niy;
            }
            
            $data = Guru::create([
                'nama_guru' => $request->nama_guru,
                'email' => $request->email, 
                'password' => Hash::make($kostumisasi_password),
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
                // 'percakapan' => $percakapan
            ]);   
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage(),
            ], 400);
        }
    }

    public function edit_guru(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|unique:admins|unique:murids|unique:gurus,email,' . $id,
            'foto_profile' => 'mimes:jpeg,png,jpg|file|max:2048',
            'nama_guru' => 'required',
            'niy' => 'required|unique:gurus,niy,' . $id,
            // 'password' => 'required',
            // 'kode_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => [],
            ], 400);
        }

        $file_path = Guru::where('id', $id)->value('foto_profile');

        if ($request->hasFile('foto_profile')) {
            Storage::delete($file_path);
            $berkas = $request->file('foto_profile');
            $nama = time().'-'.$berkas->getClientOriginalName();
            $edit = $berkas->storeAs('gambar_profile_guru', $nama);
        } else {
            $edit = $file_path;
        }

        try {
            $guru = Guru::where('id', $id)->first();

            $guru->update([
                'nama_guru' => $request->nama_guru,
                'email' => $request->email, 
                'niy' => $request->niy,
                'foto_profile' => $edit,
                'nomor_tlp' => $request->nomor_tlp,
                'alamat' => $request->alamat,
                // 'password' => Hash::make($request->password),
                // 'kode_id' => $request->kode_id
            ]);

            return response()->json([
                'message' => 'Data Guru berhasil di ubah',
                'data' => $guru,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage(),
            ], 400);
        }
    }

    public function hapus_guru($id)
    {
        
        $file_path = Guru::where('id', $id)->value('foto_profile');
        Storage::delete($file_path);
        
        $guru = Guru::where('id', $id)->first();
        $kode = Kode::where('guru_id', $id)->first();
        $mapel = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->where('guru_id', $id)
        ->first();
        $percakapan = Percakapan::whereIn('user_one', array($id))->get();

        if (empty($kode)) {
            $guru->delete();
        }elseif (!empty($mapel) && $kode->status_mapel == 'bk'){
            Percakapan::whereIn('user_one', array($guru->id))->delete();
            $mapel->delete();
            $kode->delete();
            $guru->delete();
        } elseif (!empty($mapel)) {
            $mapel->delete();
            $kode->delete();
            $guru->delete();
        } else {
            $kode->delete();
            $guru->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Data guru berhasil di hapus',
            // 'data' => $percakapan
        ]);
    }

    public function tambah_kode(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'kode_guru'=> 'unique:kodes',
            'nama_mapel'=> 'required',
            'status_mapel'=> 'required',
            // 'guru_id'=> 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => [],
            ], 400);
        }

        try {
            $nama_guru = Guru::where('id', $id)
            ->value('nama_guru');

            $cek_mapel = Kode::join('gurus', 'gurus.id', '=', 'kodes.guru_id')
            ->where('gurus.id', $id)
            ->where('kodes.nama_mapel', 'LIKE', '%' . $request->nama_mapel . '%')
            ->first();
            
            if (!empty($cek_mapel)) {
                return response()->json([
                    'message' => 'Mapel sudah diampu oleh '. $nama_guru,
                    'data' => [],
                ]);
            }
            $cek_kode = Kode::join('gurus', 'gurus.id', '=', 'kodes.guru_id')
            ->where('gurus.id', $id)
            ->latest('kodes.created_at')
            ->value('kode_guru');
            
            $cek_kode_nomor = substr($cek_kode, -1);
            
            
            $nomor_kode = 1;
            if (!empty($cek_kode)) {
                if (empty(explode(' ',trim($nama_guru))[1])) {
                    $nama_depan = explode(' ',trim($nama_guru))[0];
                    $kostumisasi_nama_kode = strtoupper(substr($nama_depan, 0, 2)).$cek_kode_nomor+1;
                } else {
                    $nama_depan = explode(' ',trim($nama_guru))[0];
                    $nama_lanjut = explode(' ',trim($nama_guru))[1];
                    $kostumisasi_nama_kode = strtoupper(substr($nama_depan, 0, 1)).strtoupper(substr($nama_lanjut, 0, 1)).$cek_kode_nomor+1;
                }
                
            }else {
                if (empty(explode(' ',trim($nama_guru))[1])) {
                    $nama_depan = explode(' ',trim($nama_guru))[0];
                    $kostumisasi_nama_kode = strtoupper(substr($nama_depan, 0, 2)).$nomor_kode;
                } else {
                    $nama_depan = explode(' ',trim($nama_guru))[0];
                    $nama_lanjut = explode(' ',trim($nama_guru))[1];
                    $kostumisasi_nama_kode = strtoupper(substr($nama_depan, 0, 1)).strtoupper(substr($nama_lanjut, 0, 1)).$nomor_kode;
                }
            }
            
            
            $data = Kode::create([
                'kode_guru'=> $kostumisasi_nama_kode,
                'nama_mapel'=> $request->nama_mapel,
                'status_mapel'=> $request->status_mapel,
                'guru_id'=> $id,
            ]);
    
            $kode_id = Kode::latest()->first();
            $id_guru = Guru::where('id', $id)->first();

            $id_guru->update([
                'kode_id' => $kode_id->id
            ]);
    
            return response()->json([
                'message' => 'Data kode guru baru berhasil dibuat',
                'data' => $data,
            ]);

            
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage(),
            ], 400);
        }

        
    }

    public function hapus_kode($id)
    {
        //  **MASIH ADA REVISI**
        $mapel = Mapel::where('kode_id', $id)->first();
        $kode = Kode::where('id', $id)->first();

        if ($kode->status_mapel == 'bk') {
            Percakapan::whereIn('user_one', array($kode->guru_id))->delete();
            $kode->delete();
            $mapel->delete();
        } elseif (empty($mapel)) {
            $kode->delete();
            // $mapel->delete();
        }else {
            $kode->delete();
            $mapel->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Data kode berhasil di hapus',
        ]);
    }

    public function importView(Request $request){
        return view('importFile');
    }
 
    public function import(Request $request){
        Excel::import(new ImportGuru,
                      $request->file('file')->store('file_data'));
        // return redirect()->back();
        return response()->json([
            'success' => true,
            'message' => 'berhasil import data'
        ]);
    }

    public function downloadFile() {
        Excel::store(new ExportGuru(), 'nugasyuk_export_dataguru.xlsx');
        return response()->download(storage_path('app/'.'nugasyuk_export_dataguru.xlsx'), 'nugasyuk_export_dataguru.xlsx');
    }
 
    public function exportsGuru(Request $request){
        return new ExportGuru();
        // return Excel::download(new ExportGuru, 'nugasyuk_dataguru.xlsx');
    }

    public function data_all()
    {
        $data = Guru::select([
            'id',
            'niy',
            'nama_guru',
            'email',
            // 'password',
            'foto_profile',
            'alamat',
            'nomor_tlp',
            'kode_id'
        ])->get();

        return response()->json([
            'success' => true,
            'message' => 'Data guru',
            'data' => $data
        ]);
    }

}
