<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Hari;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AdminJadwalResource;

class JadwalController extends Controller
{
    public function index()
    {
        $hari = Hari::orderBy('id', 'ASC')
        ->select(['id', 'hari'])->get();

        $data = AdminJadwalResource::collection($hari);

        return response()->json([
            "success" => true,
            "message" => "Jadwal Mapel Murid",
            // "nama_kelas" =>
            "data" => $data,
        ], 200);
    }

    public function detail($id)
    {
        $kelas = request ('kelas', 1);
        $jadwal = Jadwal::join('mapels', 'mapels.id', '=', 'jadwals.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('haris', 'haris.id', '=', 'jadwals.hari_id')
        ->join('jams', 'jams.id', '=', 'jadwals.jam_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->when($kelas, function ($query) use ($kelas){
            return $query->whereHas('mapel', function ($query) use ($kelas){
                $query->where('kelas_id', $kelas);
            });
        })
        ->where('haris.id', $id)
        ->get([
            'jadwals.id',
            'tingkatans.tingkat_ke',
            'jurusans.nama_jurusan',
            'kelas.nama_kelas',
            'kodes.nama_mapel',
            'gurus.nama_guru',
            'haris.hari',
            'jams.waktu_mulai',
            'jams.waktu_selesai'
        ]);

        $hari = Hari::where('id', $id)
        ->select(['id', 'hari'])->value('hari');

        if (count($jadwal) == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ada',
            ], 404);
        }
        else {
            return response()->json([
                "success" => true,
                "message" => "List Jadwal",
                "hari" => $hari,
                "tugas" => $jadwal,
            ], 200);
        }
    }

    public function buat_jadwal(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'hari_id' => 'required',
            'jam_id' => 'required',
            'mapel_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => [],
            ]);
        }   

        $data = Jadwal::create([
            'hari_id' => $request->hari_id,
            'jam_id' => $request->jam_id,
            'mapel_id' => $request->mapel_id
        ]);

        return response()->json([
            'message' => 'Data Kelas baru berhasil dibuat',
            'data' => $data,
        ]);
    }

    public function edit_jadwal(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'hari_id' => 'required',
            'jam_id' => 'required',
            'mapel_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => [],
            ]);
        }

        try {
            $jadwal = Jadwal::where('id', $id)->first();

            $jadwal->update([
                'hari_id' => $request->hari_id,
                'jam_id' => $request->jam_id,
                'mapel_id' => $request->mapel_id
            ]);

            return response()->json([
                'message' => 'Data jadwal berhasil di ubah',
                'data' => $jadwal,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage(),
            ]);
        }
    }

    public function hapus_jadwal($id)
    {
        $jadwal = Jadwal::where('id', $id)->first();

        $jadwal->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data jadwal berhasil di hapus',
        ]);
    }
}
