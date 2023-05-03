<?php

namespace App\Http\Controllers\API\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = array();
        $profile[]=[
            'foto_profile'=>auth()->user()->foto_profile,
            'email'=>auth()->user()->email,
            'nama_guru'=>auth()->user()->nama_guru,
            'mapel_guru'=>auth()->user()->mapel->kode->nama_mapel
        ];

        return response()->json([
            "success" => true,
            "message" => "Profile Guru",
            "profile_guru" => $profile,
        ], 200);
    }
}
