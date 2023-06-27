<?php

namespace App\Http\Controllers\API\Guru;

use App\Models\Guru;
use App\Models\Mapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        // $profile = array();
        // $profile[]=[
        //     'foto_profile'=>auth()->user()->foto_profile,
        //     'email'=>auth()->user()->email,
        //     'nama_guru'=>auth()->user()->nama_guru,
        //     'mapel_guru'=>auth()->user()->mapel->kode->nama_mapel
        // ];

        $profile = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('gurus.id', auth()->user()->id)
        ->select(['foto_profile', 'email', 'nama_guru'])->first();

        $mapel = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('kodes.guru_id', auth()->user()->id)
        ->select(['kodes.nama_mapel'])->get();

        $data = [
            "foto_profile" => $profile->foto_profile,
            "email" => $profile->email,
            "nama_guru" => $profile->nama_guru,
            "mapel" => $mapel
        ];

        return response()->json([
            "success" => true,
            "message" => "Profile Guru",
            "data" => $data,
        ], 200);
    }

    public function resetpassword(Request $request)
    {
        if (Hash::check($request->password_lama, auth()->user()->password)) {    
            $validateData = Validator::make($request->all(),[
                'password'=>'required|min:5|max:255',
                'konfirmasi'=>'required|min:5|max:255|same:password',
                // 'updated_at' => now()
            ]);

            if ($validateData->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validateData->errors(),
                    'data' => [],
                ]);
            }
        
            Guru::where('id', auth()->user()->id)->update([
                'password'=>Hash::make($request->password),
                // 'konfirmasi'=>Hash::make($request->konfirmasi),
                'updated_at' => now()
            ]);
            return response()->json([
                'message' => 'password changed successfully',
                // 'data' => $data
            ],200);
        
        }

        return response()->json([
            'message' => 'forbidden',
            'errors' => 'passwords do not match'
        ],403);
    }
}
